<?php

    namespace Modules\User\Listeners;

    use Illuminate\Support\Facades\Mail;
    use Modules\User\Emails\RegisteredEmail;
    use Modules\User\Events\SendMailUserRegistered;
    use Modules\User\Models\User;

    class SendMailUserRegisteredListen
    {
        /**
         * Create the event listener.
         *
         * @return void
         */
        public $user;

        const CODE = [
            'first_name' => '[first_name]',
            'last_name'  => '[last_name]',
            'name'       => '[name]',
            'email'      => '[email]',
        ];

        public function __construct(User $user)
        {
            $this->user = $user;
            //
        }

        /**
         * Handle the event.
         *
         * @param Event $event
         * @return void
         */
        public function handle(SendMailUserRegistered $event)
        {
            if($event->user->locale){
                $old = app()->getLocale();
                app()->setLocale($event->user->locale);
            }

            if (!empty(setting_item('enable_mail_user_registered'))) {
                $body = $this->replaceContentEmail($event, setting_item_with_lang('user_content_email_registered',app_get_locale()));
                Mail::to($event->user->email)->send(new RegisteredEmail($event->user, $body, 'customer'));
            }

            if(!empty($old)){
                app()->setLocale($old);
            }

            if (!empty(setting_item('admin_email') and !empty(setting_item_with_lang('admin_enable_mail_user_registered',app_get_locale())))) {
                $body = $this->replaceContentEmail($event, setting_item_with_lang('admin_content_email_user_registered',app_get_locale()));
                Mail::to(setting_item('admin_email'))->send(new RegisteredEmail($event->user, $body, 'admin'));
            }


        }

        public function replaceContentEmail($event, $content)
        {
            if (!empty($content)) {
                foreach (self::CODE as $item => $value) {
                    $content = str_replace($value, @$event->user->$item, $content);
                }
            }
            return $content;
        }
    }
