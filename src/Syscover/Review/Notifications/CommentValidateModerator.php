<?php namespace Syscover\Review\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Syscover\Review\Models\Comment as CommentModel;

class CommentValidateModerator extends Notification
{
    use Queueable;

    private $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
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
                    ->subject(__('review::pulsar.comment_validate_moderator_01', ['id' => $this->comment->id]))
                    ->greeting(__('review::pulsar.comment_validate_moderator_02'))
                    ->line(__('review::pulsar.comment_validate_moderator_03'))
                    ->action(__('review::pulsar.comment_validate_moderator_04'), config('pulsar-admin.panel_url') . '/apps/review/comment/show/' . $this->comment->id)
                    ->line(__('review::pulsar.comment_validate_moderator_05'))
                    ->salutation(__('review::pulsar.comment_validate_moderator_06'));
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
