<?php namespace Syscover\Review\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Syscover\Review\Models\Review as ReviewModel;

class ReviewOwnerObject extends Notification
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
                    ->greeting('Holaaaa!')
                    ->line('Tienes una review pendiente de validar.')
                    //->action('Ver Review', url('pulsar/review/review/show/' . $this->review->id))
                    ->action('Responder al cliente', 'http://localhost:4200/pulsar/review/review/show/' . $this->review->id)
                    ->line('Thank you for using our application!')
                    ->salutation('Hasta luego lucas');
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
