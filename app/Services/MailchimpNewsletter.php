<?php 

namespace App\Services;

use App\Services\NewsLetter;
use MailchimpMarketing\ApiClient;

class MailchimpNewsletter implements NewsLetter 
{
    // public function __construct(protected ApiClient $client)
    // {
    // }

    public function subscribe(string $email, string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');

        return $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }
}