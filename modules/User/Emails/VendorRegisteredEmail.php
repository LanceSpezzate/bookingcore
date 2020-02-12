<?php

namespace Modules\User\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Events\VendorApproved;

class VendorRegisteredEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    const CODE = [
        'buttonReset' => '[button_reset_password]',
    ];
    public $user;

    public function __construct($user,$to)
    {
        $this->user = $user;
    }

    public function build()
    {
        $subject = __('New Vendor Registration');

        return $this->subject($subject)->view('User::emails.vendor-registered',['user'=>$this->user]);
    }


}
