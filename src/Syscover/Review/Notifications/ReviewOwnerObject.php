<?php namespace Syscover\Review\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Syscover\Review\Models\Review as ReviewModel;

class ReviewOwnerObject extends Notification implements ShouldQueue
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
                    ->subject(__('review::pulsar.review_owner_object_01', ['id' => $this->review->id]))
                    ->greeting(__('review::pulsar.review_owner_object_02'))
                    ->line(__('review::pulsar.review_owner_object_03'))
                    ->line(__('review::pulsar.review_owner_object_04'))
                    ->action(__('review::pulsar.review_owner_object_05'),
                        $this->review->review_completed_url ? $this->review->review_completed_url :
                            route('pulsar.review.review_show', ['slug' => encrypt([
                                'review_id'     => $this->review->id,
                                'owner_type_id' => 1 // owner of object
                            ])])
                    )
                    ->line(__('review::pulsar.review_owner_object_06'))
                    ->salutation(__('review::pulsar.review_owner_object_07'));
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
