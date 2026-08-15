<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'topic' => 'required|string|in:story-pitch,correction,sponsorship,expert-contribution,general,other',
            'message' => 'required|string|min:10|max:5000',
        ]);

        $topics = [
            'story-pitch' => 'Story Pitch',
            'correction' => 'Correction / Update',
            'sponsorship' => 'Sponsorship / Partnership',
            'expert-contribution' => 'Expert Contribution',
            'general' => 'General Question',
            'other' => 'Other',
        ];

        try {
            $toEmail = 'nsential0@gmail.com';
            $subject = 'New Contact Message: ' . $topics[$validated['topic']];
            
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>New Contact Message</title>
                <style>
                    body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; }
                    .container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 12px; padding: 40px; }
                    h1 { color: #1a1a2e; font-size: 24px; }
                    .meta { color: #6b7280; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px; margin-bottom: 20px; }
                    .label { font-weight: 600; color: #374151; margin-bottom: 4px; }
                    .value { color: #1f2937; margin-bottom: 16px; }
                    .message-box { background: #f3f4f6; border-radius: 8px; padding: 16px; margin-top: 8px; }
                    .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 13px; }
                    .highlight { background: #fef3c7; padding: 2px 8px; border-radius: 4px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>New Contact Message</h1>
                    <div class="meta">Received: ' . now()->format('F d, Y h:i A') . '</div>
                    <div>
                        <div class="label">Name</div>
                        <div class="value">' . htmlspecialchars($validated['name']) . '</div>
                        <div class="label">Email</div>
                        <div class="value"><a href="mailto:' . htmlspecialchars($validated['email']) . '">' . htmlspecialchars($validated['email']) . '</a></div>
                        <div class="label">Topic</div>
                        <div class="value"><span class="highlight">' . $topics[$validated['topic']] . '</span></div>
                        <div class="label">Message</div>
                        <div class="message-box">' . nl2br(htmlspecialchars($validated['message'])) . '</div>
                    </div>
                    <div class="footer">
                        <p><strong>Reply to:</strong> <a href="mailto:' . htmlspecialchars($validated['email']) . '">' . htmlspecialchars($validated['email']) . '</a></p>
                    </div>
                </div>
            </body>
            </html>';

            Mail::send([], [], function ($message) use ($toEmail, $subject, $html) {
                $message->to($toEmail)
                        ->subject($subject)
                        ->html($html);
            });

            return redirect()->back()->with('success', 'Your message has been sent! We will get back to you within 1 business day.');

        } catch (\Exception $e) {
            Log::error('Contact email failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send message. Please try again later.')->withInput();
        }
    }
}