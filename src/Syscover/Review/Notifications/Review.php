<?php namespace Syscover\Review\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Syscover\Review\Models\Review as ReviewModel;

class Review extends Notification
{
    use Queueable;

    private $review;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ReviewModel $review)
    {
        $this->review = $review;
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
                    ->level('info')
                    ->subject('Hay una review pendiente de validar, Review: ' . $this->review->id)
                    ->greeting('¡Hola!')
                    ->line('Tienes una review pendiente de validar.')
                    ->action('Validar Review', config('pulsar-admin.panel_url') . '/pulsar/review/review/show/' . $this->review->id)
                    ->line('Gracias por tu tiempo')
                    ->salutation('¡Hasta pronto!');
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
