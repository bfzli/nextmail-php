<?php

declare(strict_types=1);

namespace Nextmail\Exception;

final class WebhookSignatureException extends \UnexpectedValueException implements NextmailException {}
