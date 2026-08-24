"use client";

import React, { useState } from "react";
import { useForm, Controller } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { supabase } from "@/lib/supabaseClient";

export type FieldType = "text" | "number" | "email" | "textarea" | "select" | "file";

export interface FormFieldSchema {
  id?: string;
  label: string;
  field_key: string;
  type: FieldType;
  is_required: boolean;
  options?: string[]; // For select type
}

interface DynamicFormProps {
  eventId: string;
  schema: FormFieldSchema[];
  onSubmitSuccess?: () => void;
}

export function DynamicForm({ eventId, schema, onSubmitSuccess }: DynamicFormProps) {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [error, setError] = useState<string | null>(null);

  // Generate Zod schema dynamically
  const generateZodSchema = () => {
    const schemaShape: Record<string, any> = {};
    schema.forEach((field) => {
      let validator: any = z.string();
      
      if (field.type === "email") {
        validator = z.string().email("Format email tidak valid");
      }
      
      if (!field.is_required) {
        validator = validator.optional().or(z.literal(""));
      } else {
        validator = validator.min(1, `${field.label} wajib diisi`);
      }
      
      schemaShape[field.field_key] = validator;
    });
    
    return z.object(schemaShape);
  };

  const dynamicZodSchema = generateZodSchema();
  type FormData = z.infer<typeof dynamicZodSchema>;

  const { control, handleSubmit, formState: { errors } } = useForm<FormData>({
    resolver: zodResolver(dynamicZodSchema),
  });

  const onSubmit = async (data: FormData) => {
    setIsSubmitting(true);
    setError(null);
    try {
      // Get current user (assumes the user is logged in via Supabase Auth)
      const { data: userData, error: userError } = await supabase.auth.getUser();
      if (userError || !userData.user) throw new Error("Anda harus login untuk mendaftar.");

      // Process file uploads if any
      const finalPayload = { ...data };
      for (const field of schema) {
        if (field.type === "file" && finalPayload[field.field_key]) {
          // In a real implementation, you would handle the file object, 
          // upload to S3 using lib/s3Client, and save the URL here.
          // For simplicity in this UI component, we assume file inputs are handled
          // by a separate FileUpload sub-component that returns the S3 URL as string.
        }
      }

      // Submit to Supabase
      const { error: insertError } = await supabase
        .from("event_registrations")
        .insert({
          event_id: eventId,
          user_id: userData.user.id,
          payload: finalPayload
        });

      if (insertError) throw insertError;
      
      if (onSubmitSuccess) onSubmitSuccess();
    } catch (err: any) {
      setError(err.message || "Terjadi kesalahan saat menyimpan data.");
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-6 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      {error && <div className="p-3 bg-red-50 text-red-600 rounded-md text-sm">{error}</div>}
      
      {schema.map((field) => (
        <div key={field.field_key} className="flex flex-col space-y-1">
          <label className="text-sm font-medium text-foreground">
            {field.label} {field.is_required && <span className="text-red-500">*</span>}
          </label>
          
          <Controller
            name={field.field_key}
            control={control}
            render={({ field: hookField }) => {
              if (field.type === "textarea") {
                return <textarea {...hookField} className="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all" rows={4} />;
              }
              if (field.type === "select") {
                return (
                  <select {...hookField} className="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all bg-white">
                    <option value="">Pilih {field.label}...</option>
                    {field.options?.map((opt) => (
                      <option key={opt} value={opt}>{opt}</option>
                    ))}
                  </select>
                );
              }
              if (field.type === "file") {
                // Here we use a simple text input for the URL, but it should be a file uploader
                return (
                  <div className="flex items-center space-x-2">
                     <input 
                      type="file" 
                      onChange={(e) => {
                         // Mocking file upload handling
                         // The actual uploadToS3 logic goes here.
                         hookField.onChange("https://mock-s3-url.com/file.pdf");
                      }} 
                      className="border border-gray-300 rounded-md p-1.5 w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                    />
                  </div>
                );
              }
              return <input type={field.type} {...hookField} className="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all" />;
            }}
          />
          {errors[field.field_key] && (
            <span className="text-xs text-red-500">{errors[field.field_key]?.message as string}</span>
          )}
        </div>
      ))}

      <button 
        type="submit" 
        disabled={isSubmitting}
        className="w-full bg-primary text-white font-medium py-2.5 rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50"
      >
        {isSubmitting ? "Mengirim..." : "Kirim Pendaftaran"}
      </button>
    </form>
  );
}
