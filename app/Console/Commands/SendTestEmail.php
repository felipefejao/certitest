<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

#[Signature('certitest:send-test-email {email : Recipient address}')]
#[Description('Send a test email through the configured mailer to verify the Google Workspace integration')]
class SendTestEmail extends Command
{
    public function handle(): int
    {
        $email = (string) $this->argument('email');

        $validator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email:rfc']]
        );

        if ($validator->fails()) {
            $this->error("Invalid recipient address: {$email}");

            return self::FAILURE;
        }

        Mail::to($email)->send(new TestEmail);

        $this->info("Test email queued for {$email} via [".config('mail.default').'] mailer.');

        return self::SUCCESS;
    }
}
