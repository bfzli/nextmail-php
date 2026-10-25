<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class WebhookEvents
{
    public const EMAIL_RECEIVED = 'email.received';
    public const EMAIL_REPLIED = 'email.replied';
    public const EMAIL_SENT = 'email.sent';
    public const EMAIL_FAILED = 'email.failed';
    public const EMAIL_CANCELLED = 'email.cancelled';
    public const EMAIL_SCHEDULED = 'email.scheduled';
    public const EMAIL_QUEUED = 'email.queued';
    public const EMAIL_DELIVERED = 'email.delivered';
    public const EMAIL_DELIVERY_DELAYED = 'email.delivery_delayed';
    public const EMAIL_BOUNCED = 'email.bounced';
    public const EMAIL_COMPLAINED = 'email.complained';
    public const EMAIL_SUPPRESSED = 'email.suppressed';
    public const EMAIL_OPENED = 'email.opened';
    public const EMAIL_CLICKED = 'email.clicked';
    public const EMAIL_DOWNLOADED = 'email.downloaded';
    public const EMAIL_ROUTED = 'email.routed';
    public const DOMAIN_VERIFIED = 'domain.verified';
    public const DOMAIN_SENDING_CHANGED = 'domain.sending_changed';
    public const DOMAIN_DELETED = 'domain.deleted';
    public const SUPPRESSION_ADDED = 'suppression.added';
    public const SUPPRESSION_REMOVED = 'suppression.removed';
    public const FILE_UPLOADED = 'file.uploaded';
    public const FILE_DELETED = 'file.deleted';
    public const FORM_SUBMITTED = 'form.submitted';
    public const FORM_CONFIRMED = 'form.confirmed';
    public const AUTOMATION_ENTERED = 'automation.entered';
    public const AUTOMATION_EXITED = 'automation.exited';
    public const AUTOMATION_PAUSED = 'automation.paused';
    public const AUTOMATION_RESUMED = 'automation.resumed';
    public const AUTOMATION_WEBHOOK = 'automation.webhook';
    public const CONTACT_CREATED = 'contact.created';
    public const CONTACT_UPDATED = 'contact.updated';
    public const CONTACT_DELETED = 'contact.deleted';
    public const CONTACT_UNSUBSCRIBED = 'contact.unsubscribed';
    public const CONTACT_RESUBSCRIBED = 'contact.resubscribed';
    public const SENDING_PAUSED = 'sending.paused';
    public const SENDING_RESUMED = 'sending.resumed';
    public const CONNECTOR_CONNECTED = 'connector.connected';
    public const CONNECTOR_DISCONNECTED = 'connector.disconnected';
    public const CONNECTOR_NEEDS_ATTENTION = 'connector.needs_attention';
    public const TASK_RUN_COMPLETED = 'task.run.completed';
    public const TASK_RUN_FAILED = 'task.run.failed';
    public const TASK_RUN_CANCELLED = 'task.run.cancelled';
    public const APPROVAL_REQUESTED = 'approval.requested';
    public const BOOKING_CREATED = 'booking.created';
    public const BOOKING_CONFIRMED = 'booking.confirmed';
    public const BOOKING_RESCHEDULED = 'booking.rescheduled';
    public const BOOKING_CANCELLED = 'booking.cancelled';
    public const BROADCAST_SENDING = 'broadcast.sending';
    public const BROADCAST_SENT = 'broadcast.sent';
    public const BROADCAST_FAILED = 'broadcast.failed';
    public const BROADCAST_CANCELLED = 'broadcast.cancelled';
    public const ADDRESS_EXPIRED = 'address.expired';

    public static function values(): array
    {
        return [
            self::EMAIL_RECEIVED,
            self::EMAIL_REPLIED,
            self::EMAIL_SENT,
            self::EMAIL_FAILED,
            self::EMAIL_CANCELLED,
            self::EMAIL_SCHEDULED,
            self::EMAIL_QUEUED,
            self::EMAIL_DELIVERED,
            self::EMAIL_DELIVERY_DELAYED,
            self::EMAIL_BOUNCED,
            self::EMAIL_COMPLAINED,
            self::EMAIL_SUPPRESSED,
            self::EMAIL_OPENED,
            self::EMAIL_CLICKED,
            self::EMAIL_DOWNLOADED,
            self::EMAIL_ROUTED,
            self::DOMAIN_VERIFIED,
            self::DOMAIN_SENDING_CHANGED,
            self::DOMAIN_DELETED,
            self::SUPPRESSION_ADDED,
            self::SUPPRESSION_REMOVED,
            self::FILE_UPLOADED,
            self::FILE_DELETED,
            self::FORM_SUBMITTED,
            self::FORM_CONFIRMED,
            self::AUTOMATION_ENTERED,
            self::AUTOMATION_EXITED,
            self::AUTOMATION_PAUSED,
            self::AUTOMATION_RESUMED,
            self::AUTOMATION_WEBHOOK,
            self::CONTACT_CREATED,
            self::CONTACT_UPDATED,
            self::CONTACT_DELETED,
            self::CONTACT_UNSUBSCRIBED,
            self::CONTACT_RESUBSCRIBED,
            self::SENDING_PAUSED,
            self::SENDING_RESUMED,
            self::CONNECTOR_CONNECTED,
            self::CONNECTOR_DISCONNECTED,
            self::CONNECTOR_NEEDS_ATTENTION,
            self::TASK_RUN_COMPLETED,
            self::TASK_RUN_FAILED,
            self::TASK_RUN_CANCELLED,
            self::APPROVAL_REQUESTED,
            self::BOOKING_CREATED,
            self::BOOKING_CONFIRMED,
            self::BOOKING_RESCHEDULED,
            self::BOOKING_CANCELLED,
            self::BROADCAST_SENDING,
            self::BROADCAST_SENT,
            self::BROADCAST_FAILED,
            self::BROADCAST_CANCELLED,
            self::ADDRESS_EXPIRED,
        ];
    }
}
