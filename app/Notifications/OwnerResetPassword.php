<?php

namespace App\Notifications;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OwnerResetPassword extends Notification
{
    /**
    * The password reset token.
    * @var string
    */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
        config()->set('auth.defaults.guard', 'shop');
        \Config::set('user', 'shop');
        \Config::set('auth.providers.users.model', \App\Model\Shop::class);

    }

    public function broker() {
        return Password::broker('shops');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
           ->subject('パスワード再設定')
           ->line('下のボタンをクリックしてパスワードを再設定してください。')
           ->action('パスワード再設定', url(config('app.url').route('shop.password.reset', 'token='.$this->token, false)))
           ->line('もし心当たりがない場合は、本メッセージを破棄してください。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
