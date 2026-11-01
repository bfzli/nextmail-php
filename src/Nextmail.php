<?php

declare(strict_types=1);

namespace Nextmail;

use Nextmail\Http\HttpClient;
use Nextmail\Internal\Credentials;
use Nextmail\Internal\Defaults;
use Nextmail\Internal\Endpoint;
use Nextmail\Internal\LanguageIndex;
use Nextmail\Internal\Protocol;
use Nextmail\Internal\RawBody;
use Nextmail\Resources\Account;
use Nextmail\Resources\Addresses;
use Nextmail\Resources\Analytics;
use Nextmail\Resources\AppHost;
use Nextmail\Resources\Audiences;
use Nextmail\Resources\Automations;
use Nextmail\Resources\Billing;
use Nextmail\Resources\Bookings;
use Nextmail\Resources\Branding;
use Nextmail\Resources\Broadcasts;
use Nextmail\Resources\Calendar;
use Nextmail\Resources\Chats;
use Nextmail\Resources\ConnectedMailboxes;
use Nextmail\Resources\Connectors;
use Nextmail\Resources\Contacts;
use Nextmail\Resources\DnsConnections;
use Nextmail\Resources\Domains;
use Nextmail\Resources\Drafts;
use Nextmail\Resources\Emails;
use Nextmail\Resources\Encryption;
use Nextmail\Resources\Events;
use Nextmail\Resources\Exports;
use Nextmail\Resources\Files;
use Nextmail\Resources\FollowUps;
use Nextmail\Resources\Forms;
use Nextmail\Resources\Imports;
use Nextmail\Resources\Keys;
use Nextmail\Resources\Knowledge;
use Nextmail\Resources\Labels;
use Nextmail\Resources\Languages;
use Nextmail\Resources\LiveEvents;
use Nextmail\Resources\Me;
use Nextmail\Resources\Members;
use Nextmail\Resources\Notifications;
use Nextmail\Resources\OutOfOffice;
use Nextmail\Resources\ProviderImports;
use Nextmail\Resources\Roles;
use Nextmail\Resources\Rules;
use Nextmail\Resources\Security;
use Nextmail\Resources\Segments;
use Nextmail\Resources\Senders;
use Nextmail\Resources\Sending;
use Nextmail\Resources\Settings;
use Nextmail\Resources\Shared;
use Nextmail\Resources\ShareLinks;
use Nextmail\Resources\Signatures;
use Nextmail\Resources\Signups;
use Nextmail\Resources\Subscriptions;
use Nextmail\Resources\Support;
use Nextmail\Resources\Suppressions;
use Nextmail\Resources\Tasks;
use Nextmail\Resources\Templates;
use Nextmail\Resources\TempMail;
use Nextmail\Resources\Threads;
use Nextmail\Resources\Tools;
use Nextmail\Resources\Tracking;
use Nextmail\Resources\Traffic;
use Nextmail\Resources\Webhooks;
use Nextmail\Resources\Workspaces;

final class Nextmail
{
    public const VERSION = '0.1.1';

    private static ?self $default = null;

    public readonly string $mode;

    public readonly Transport $raw;

    public readonly Me $me;

    public readonly Security $security;

    public readonly Keys $keys;

    public readonly Addresses $addresses;

    public readonly Languages $languages;

    public readonly LiveEvents $liveEvents;

    public readonly Emails $emails;

    public readonly Templates $templates;

    public readonly Tracking $tracking;

    public readonly Threads $threads;

    public readonly FollowUps $followUps;

    public readonly Drafts $drafts;

    public readonly Labels $labels;

    public readonly Contacts $contacts;

    public readonly Audiences $audiences;

    public readonly Billing $billing;

    public readonly Forms $forms;

    public readonly Automations $automations;

    public readonly Events $events;

    public readonly Broadcasts $broadcasts;

    public readonly Domains $domains;

    public readonly AppHost $appHost;

    public readonly Branding $branding;

    public readonly Rules $rules;

    public readonly Webhooks $webhooks;

    public readonly Imports $imports;

    public readonly ProviderImports $providerImports;

    public readonly Calendar $calendar;

    public readonly Settings $settings;

    public readonly OutOfOffice $outOfOffice;

    public readonly Roles $roles;

    public readonly Members $members;

    public readonly Suppressions $suppressions;

    public readonly Traffic $traffic;

    public readonly Sending $sending;

    public readonly Files $files;

    public readonly Knowledge $knowledge;

    public readonly TempMail $tempMail;

    public readonly Signups $signups;

    public readonly Exports $exports;

    public readonly Chats $chats;

    public readonly Encryption $encryption;

    public readonly Support $support;

    public readonly Tools $tools;

    public readonly Senders $senders;

    public readonly Analytics $analytics;

    public readonly Subscriptions $subscriptions;

    public readonly DnsConnections $dnsConnections;

    public readonly Workspaces $workspaces;

    public readonly Account $account;

    public readonly Notifications $notifications;

    public readonly Signatures $signatures;

    public readonly Tasks $tasks;

    public readonly Bookings $bookings;

    public readonly Connectors $connectors;

    public readonly ConnectedMailboxes $connectedMailboxes;

    public readonly Segments $segments;

    public readonly ShareLinks $shareLinks;

    public readonly Shared $shared;

    public function __construct(
        #[\SensitiveParameter]
        ?string $apiKey = null,
        #[\SensitiveParameter]
        string|callable|null $accessToken = null,
        #[\SensitiveParameter]
        ?string $baseUrl = null,
        ?HttpClient $httpClient = null,
        ?int $maxRetries = null,
        int|float|null $timeout = null,
        ?string $userAgent = null,
        #[\SensitiveParameter]
        array $headers = [],
        bool $disableUpdateNotice = false,
    ) {
        $explicit = $apiKey !== null || $accessToken !== null;
        $key = $explicit ? $apiKey : Credentials::fromEnvironment(Protocol::ENV_VARS['API_KEY']);
        $token = $explicit || $key !== null ? $accessToken : Credentials::fromEnvironment(Protocol::ENV_VARS['ACCESS_TOKEN']);
        $provider = Credentials::provider($token);

        Credentials::assertCredential($key, $provider, true);

        $this->raw = new Transport(
            apiKey: $key,
            accessToken: $provider,
            baseUrl: self::baseUrl($baseUrl),
            httpClient: $httpClient,
            maxRetries: $maxRetries,
            timeout: $timeout,
            userAgent: $userAgent,
            headers: $headers,
            disableUpdateNotice: $disableUpdateNotice,
        );
        $this->mode = Credentials::modeOf($key);
        $this->me = new Me($this->raw);
        $this->security = new Security($this->raw);
        $this->keys = new Keys($this->raw);
        $this->addresses = new Addresses($this->raw);
        $this->languages = new Languages($this->raw);
        $this->liveEvents = new LiveEvents($this->raw);
        $this->emails = new Emails($this->raw);
        $this->templates = new Templates($this->raw);
        $this->tracking = new Tracking($this->raw);
        $this->threads = new Threads($this->raw);
        $this->followUps = new FollowUps($this->raw);
        $this->drafts = new Drafts($this->raw);
        $this->labels = new Labels($this->raw);
        $this->contacts = new Contacts($this->raw);
        $this->audiences = new Audiences($this->raw);
        $this->billing = new Billing($this->raw);
        $this->forms = new Forms($this->raw);
        $this->automations = new Automations($this->raw);
        $this->events = new Events($this->raw);
        $this->broadcasts = new Broadcasts($this->raw);
        $this->domains = new Domains($this->raw);
        $this->appHost = new AppHost($this->raw);
        $this->branding = new Branding($this->raw);
        $this->rules = new Rules($this->raw);
        $this->webhooks = new Webhooks($this->raw);
        $this->imports = new Imports($this->raw);
        $this->providerImports = new ProviderImports($this->raw);
        $this->calendar = new Calendar($this->raw);
        $this->settings = new Settings($this->raw);
        $this->outOfOffice = new OutOfOffice($this->raw);
        $this->roles = new Roles($this->raw);
        $this->members = new Members($this->raw);
        $this->suppressions = new Suppressions($this->raw);
        $this->traffic = new Traffic($this->raw);
        $this->sending = new Sending($this->raw);
        $this->files = new Files($this->raw);
        $this->knowledge = new Knowledge($this->raw);
        $this->tempMail = new TempMail($this->raw);
        $this->signups = new Signups($this->raw);
        $this->exports = new Exports($this->raw);
        $this->chats = new Chats($this->raw);
        $this->encryption = new Encryption($this->raw);
        $this->support = new Support($this->raw);
        $this->tools = new Tools($this->raw);
        $this->senders = new Senders($this->raw);
        $this->analytics = new Analytics($this->raw);
        $this->subscriptions = new Subscriptions($this->raw);
        $this->dnsConnections = new DnsConnections($this->raw);
        $this->workspaces = new Workspaces($this->raw);
        $this->account = new Account($this->raw);
        $this->notifications = new Notifications($this->raw);
        $this->signatures = new Signatures($this->raw);
        $this->tasks = new Tasks($this->raw);
        $this->bookings = new Bookings($this->raw);
        $this->connectors = new Connectors($this->raw);
        $this->connectedMailboxes = new ConnectedMailboxes($this->raw);
        $this->segments = new Segments($this->raw);
        $this->shareLinks = new ShareLinks($this->raw);
        $this->shared = new Shared($this->raw);
    }

    public static function createClient(
        #[\SensitiveParameter]
        ?string $apiKey = null,
        #[\SensitiveParameter]
        string|callable|null $accessToken = null,
        #[\SensitiveParameter]
        ?string $baseUrl = null,
        ?HttpClient $httpClient = null,
        ?int $maxRetries = null,
        int|float|null $timeout = null,
        ?string $userAgent = null,
        #[\SensitiveParameter]
        array $headers = [],
        bool $disableUpdateNotice = false,
    ): self {
        return new self($apiKey, $accessToken, $baseUrl, $httpClient, $maxRetries, $timeout, $userAgent, $headers, $disableUpdateNotice);
    }

    public static function init(
        #[\SensitiveParameter]
        ?string $apiKey = null,
        #[\SensitiveParameter]
        string|callable|null $accessToken = null,
        #[\SensitiveParameter]
        ?string $baseUrl = null,
        ?HttpClient $httpClient = null,
        ?int $maxRetries = null,
        int|float|null $timeout = null,
        ?string $userAgent = null,
        #[\SensitiveParameter]
        array $headers = [],
        bool $disableUpdateNotice = false,
    ): self {
        return self::$default = new self($apiKey, $accessToken, $baseUrl, $httpClient, $maxRetries, $timeout, $userAgent, $headers, $disableUpdateNotice);
    }

    public static function getClient(): self
    {
        return self::$default ??= new self();
    }

    public static function resetClient(): void
    {
        self::$default = null;
    }

    public static function createTempMail(
        #[\SensitiveParameter]
        ?string $baseUrl = null,
        #[\SensitiveParameter]
        ?string $inboxToken = null,
        ?HttpClient $httpClient = null,
        ?int $maxRetries = null,
        int|float|null $timeout = null,
        ?string $userAgent = null,
        #[\SensitiveParameter]
        array $headers = [],
        bool $disableUpdateNotice = false,
    ): TempMail {
        return new TempMail(new Transport(
            inboxToken: $inboxToken,
            baseUrl: self::baseUrl($baseUrl),
            httpClient: $httpClient,
            maxRetries: $maxRetries,
            timeout: $timeout,
            userAgent: $userAgent,
            headers: $headers,
            disableUpdateNotice: $disableUpdateNotice,
        ));
    }

    public static function createSignups(
        #[\SensitiveParameter]
        ?string $baseUrl = null,
        ?HttpClient $httpClient = null,
        ?int $maxRetries = null,
        int|float|null $timeout = null,
        ?string $userAgent = null,
        #[\SensitiveParameter]
        array $headers = [],
        bool $disableUpdateNotice = false,
    ): Signups {
        return new Signups(new Transport(
            baseUrl: self::baseUrl($baseUrl),
            httpClient: $httpClient,
            maxRetries: $maxRetries,
            timeout: $timeout,
            userAgent: $userAgent,
            headers: $headers,
            disableUpdateNotice: $disableUpdateNotice,
        ));
    }

    public static function verifyWebhookSignature(
        string $payload,
        mixed $headers,
        #[\SensitiveParameter]
        string $secret,
        ?int $toleranceSeconds = null,
    ): array {
        return Webhook::verify($payload, $headers, $secret, $toleranceSeconds);
    }

    public static function toBase64(mixed $bytes): string
    {
        return base64_encode(RawBody::read($bytes));
    }

    public static function isApiKey(#[\SensitiveParameter] mixed $value): bool
    {
        return Credentials::isApiKey($value);
    }

    public static function isAccessToken(#[\SensitiveParameter] mixed $value): bool
    {
        return Credentials::isAccessToken($value);
    }

    public static function isSealed(array $message): bool
    {
        $encryption = $message['encryption'] ?? null;
        $format = \is_array($encryption) ? ($encryption['format'] ?? null) : null;

        return \is_string($format) && \in_array($format, Protocol::SEALED_ENCRYPTION_FORMATS, true);
    }

    public static function resolveLanguage(?string $input): ?array
    {
        return LanguageIndex::resolve($input);
    }

    public static function languageByCode(?string $code): ?array
    {
        return LanguageIndex::byCode($code);
    }

    public static function isRtlLanguage(?string $code): bool
    {
        return LanguageIndex::isRtl($code);
    }

    public function close(): void
    {
        $this->raw->close();
    }

    public function __debugInfo(): array
    {
        return ['mode' => $this->mode, 'baseUrl' => $this->raw->baseUrl, 'credential' => Defaults::REDACTED];
    }

    private static function baseUrl(#[\SensitiveParameter] ?string $baseUrl): ?string
    {
        return Endpoint::normalise($baseUrl ?? Credentials::fromEnvironment(Protocol::ENV_VARS['BASE_URL']));
    }
}
