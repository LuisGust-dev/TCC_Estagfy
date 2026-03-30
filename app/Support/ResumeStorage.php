<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ResumeStorage
{
    public static function store(UploadedFile $file): string
    {
        if (! static::isSupabaseConfigured()) {
            return $file->store('resumes', 'public');
        }

        $extension = $file->getClientOriginalExtension() ?: $file->extension() ?: 'bin';
        $path = 'students/' . Str::uuid() . '.' . strtolower($extension);
        $bucket = (string) config('services.supabase.bucket');
        $url = rtrim((string) config('services.supabase.url'), '/');
        $secret = (string) config('services.supabase.secret');
        $mimeType = $file->getMimeType() ?: 'application/octet-stream';
        $encodedPath = static::encodeObjectPath($path);

        $response = Http::withHeaders([
            'apikey' => $secret,
            'Authorization' => 'Bearer ' . $secret,
            'Content-Type' => $mimeType,
            'x-upsert' => 'true',
        ])->withBody(file_get_contents($file->getRealPath()), $mimeType)
            ->post("{$url}/storage/v1/object/{$bucket}/{$encodedPath}");

        if (! $response->successful()) {
            throw new RuntimeException('Falha ao enviar currículo para o Supabase.');
        }

        return $path;
    }

    public static function publicUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (static::isSupabaseConfigured() && ! str_starts_with($path, 'resumes/')) {
            $url = rtrim((string) config('services.supabase.url'), '/');
            $bucket = (string) config('services.supabase.bucket');
            $encodedPath = static::encodeObjectPath($path);

            return "{$url}/storage/v1/object/public/{$bucket}/{$encodedPath}";
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public static function delete(?string $path): void
    {
        if (blank($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        if (static::isSupabaseConfigured() && ! str_starts_with($path, 'resumes/')) {
            $bucket = (string) config('services.supabase.bucket');
            $url = rtrim((string) config('services.supabase.url'), '/');
            $secret = (string) config('services.supabase.secret');
            $encodedPath = static::encodeObjectPath($path);

            Http::withHeaders([
                'apikey' => $secret,
                'Authorization' => 'Bearer ' . $secret,
            ])->delete("{$url}/storage/v1/object/{$bucket}/{$encodedPath}");

            return;
        }

        Storage::disk('public')->delete($path);
    }

    public static function isSupabaseConfigured(): bool
    {
        return filled(config('services.supabase.url'))
            && filled(config('services.supabase.bucket'))
            && filled(config('services.supabase.secret'));
    }

    private static function encodeObjectPath(string $path): string
    {
        return collect(explode('/', trim($path, '/')))
            ->filter()
            ->map(fn (string $segment) => rawurlencode($segment))
            ->implode('/');
    }
}
