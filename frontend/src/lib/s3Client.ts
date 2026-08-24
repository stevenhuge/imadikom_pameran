import { S3Client, PutObjectCommand, DeleteObjectCommand } from "@aws-sdk/client-s3";

const S3_ENDPOINT = process.env.NEXT_PUBLIC_S3_ENDPOINT!;
const BUCKET_NAME = process.env.NEXT_PUBLIC_S3_BUCKET_NAME!;

export const s3Client = new S3Client({
  region: "ap-southeast-1",
  endpoint: S3_ENDPOINT,
  credentials: {
    accessKeyId: process.env.SUPABASE_S3_ACCESS_KEY_ID!,
    secretAccessKey: process.env.SUPABASE_S3_SECRET_ACCESS_KEY!,
  },
  forcePathStyle: true,
});

export const uploadToS3 = async (fileBuffer: Buffer, pathKey: string, mimeType: string): Promise<string> => {
  const command = new PutObjectCommand({
    Bucket: BUCKET_NAME,
    Key: pathKey,
    Body: fileBuffer,
    ContentType: mimeType,
  });

  await s3Client.send(command);
  return `${S3_ENDPOINT}/${BUCKET_NAME}/${pathKey}`;
};

export const deleteFromS3 = async (pathKey: string): Promise<void> => {
  const command = new DeleteObjectCommand({
    Bucket: BUCKET_NAME,
    Key: pathKey,
  });

  await s3Client.send(command);
};
