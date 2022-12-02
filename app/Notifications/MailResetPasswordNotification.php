<?php

namespace App\Notifications;

use App\Http\Controllers\API\Auth\ForgotPasswordController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;

    protected $pageUrl;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
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
        $token = $this->token;
       return (new MailMessage)
        ->greeting(new HtmlString('<div style=""><h1 style="text-align:center;font-size:30px;">Kaseer</h1></div>'))
        ->line(new HtmlString('<div style="text-align:center">Masukkan Kode dibawah ini untuk melakukan reset password </div>'))
        ->line(new HtmlString('<div style="margin:20px 250px;text-align:center;font-size:25px;font-weight:bold;border:2px solid;
        background-color:green;color:white;height:50px;width:200px;padding:5px;">'.$token.'</div>'))
        ->line(new HtmlString('<div style="text-align:center">Jika tidak mengirim permintaan reset password, abaikan pesan ini!'))
        ->subject('Permintaan reset password.');
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
