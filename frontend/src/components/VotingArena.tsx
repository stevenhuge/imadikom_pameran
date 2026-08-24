"use client";

import React, { useEffect, useState } from "react";
import { supabase } from "@/lib/supabaseClient";
import { motion } from "framer-motion";

export interface Candidate {
  id: string;
  candidate_name: string;
  vision_mission: string;
  photo_url: string;
}

interface VotingArenaProps {
  eventId: string;
  candidates: Candidate[];
}

export function VotingArena({ eventId, candidates }: VotingArenaProps) {
  const [voteCounts, setVoteCounts] = useState<Record<string, number>>({});
  const [hasVoted, setHasVoted] = useState(false);
  const [isVoting, setIsVoting] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [totalVotes, setTotalVotes] = useState(0);

  useEffect(() => {
    // 1. Fetch Initial Votes
    const fetchVotes = async () => {
      const { data, error } = await supabase
        .from("votes")
        .select("voting_option_id")
        .eq("event_id", eventId);
      
      if (!error && data) {
        const counts: Record<string, number> = {};
        data.forEach(v => {
          counts[v.voting_option_id] = (counts[v.voting_option_id] || 0) + 1;
        });
        setVoteCounts(counts);
        setTotalVotes(data.length);
      }

      // Check if current user has voted
      const { data: userData } = await supabase.auth.getUser();
      if (userData?.user) {
        const { data: userVote } = await supabase
          .from("votes")
          .select("id")
          .eq("event_id", eventId)
          .eq("user_id", userData.user.id)
          .single();
        if (userVote) setHasVoted(true);
      }
    };
    fetchVotes();

    // 2. Real-time Subscription for Votes
    const channel = supabase
      .channel('public:votes')
      .on(
        'postgres_changes',
        { event: 'INSERT', schema: 'public', table: 'votes', filter: `event_id=eq.${eventId}` },
        (payload) => {
          const newVote = payload.new as any;
          setVoteCounts(prev => ({
            ...prev,
            [newVote.voting_option_id]: (prev[newVote.voting_option_id] || 0) + 1
          }));
          setTotalVotes(prev => prev + 1);
        }
      )
      .subscribe();

    return () => {
      supabase.removeChannel(channel);
    };
  }, [eventId]);

  const castVote = async (optionId: string) => {
    setIsVoting(true);
    setError(null);
    try {
      const { data: userData, error: authError } = await supabase.auth.getUser();
      if (authError || !userData.user) throw new Error("Silakan login untuk memberikan suara.");

      // Use the Stored Procedure (RPC) to cast vote atomically
      const { error: rpcError } = await supabase.rpc('cast_vote', {
        p_event_id: eventId,
        p_user_id: userData.user.id,
        p_voting_option_id: optionId
      });

      if (rpcError) {
        if (rpcError.message.includes('unique constraint')) {
           throw new Error("Anda sudah memberikan suara pada event ini.");
        }
        throw new Error(rpcError.message);
      }
      
      setHasVoted(true);
    } catch (err: any) {
      setError(err.message || "Gagal memberikan suara.");
    } finally {
      setIsVoting(false);
    }
  };

  return (
    <div className="w-full max-w-6xl mx-auto p-4">
      {error && (
        <div className="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-center">
          {error}
        </div>
      )}
      
      {hasVoted && (
        <div className="mb-8 p-4 bg-green-100 text-green-800 rounded-lg text-center font-medium shadow-sm">
          Terima kasih! Suara Anda telah tercatat dalam sistem.
        </div>
      )}

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {candidates.map((candidate) => {
          const count = voteCounts[candidate.id] || 0;
          const percentage = totalVotes > 0 ? Math.round((count / totalVotes) * 100) : 0;

          return (
            <motion.div 
              key={candidate.id}
              whileHover={!hasVoted ? { scale: 1.02, boxShadow: "0 10px 30px -10px rgba(245, 166, 35, 0.4)" } : {}}
              className="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 flex flex-col transition-all duration-300"
            >
              <div className="h-64 bg-gray-200 relative">
                {candidate.photo_url ? (
                  <img src={candidate.photo_url} alt={candidate.candidate_name} className="w-full h-full object-cover" />
                ) : (
                  <div className="w-full h-full flex items-center justify-center text-gray-400 bg-primary/5">Foto Kandidat</div>
                )}
                
                {/* Real-time Percentage Badge */}
                <div className="absolute top-4 right-4 bg-primary text-white font-bold px-3 py-1 rounded-full shadow-md">
                  {percentage}%
                </div>
              </div>

              <div className="p-6 flex-grow flex flex-col">
                <h3 className="text-xl font-bold text-primary mb-2">{candidate.candidate_name}</h3>
                <p className="text-gray-600 text-sm mb-6 flex-grow line-clamp-4">
                  {candidate.vision_mission}
                </p>
                
                {/* Progress bar container */}
                <div className="w-full bg-gray-100 rounded-full h-2.5 mb-6 overflow-hidden">
                  <motion.div 
                    initial={{ width: 0 }}
                    animate={{ width: `${percentage}%` }}
                    transition={{ duration: 1, ease: "easeOut" }}
                    className="bg-secondary h-2.5 rounded-full"
                  />
                </div>

                <button
                  onClick={() => castVote(candidate.id)}
                  disabled={hasVoted || isVoting}
                  className={`w-full py-3 rounded-xl font-bold transition-colors ${
                    hasVoted 
                      ? "bg-gray-200 text-gray-500 cursor-not-allowed" 
                      : "bg-secondary text-primary hover:bg-yellow-400 shadow-md hover:shadow-lg"
                  }`}
                >
                  {hasVoted ? "Sudah Memilih" : "VOTE SEKARANG"}
                </button>
              </div>
            </motion.div>
          );
        })}
      </div>
    </div>
  );
}
