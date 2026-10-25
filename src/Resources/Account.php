<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Account extends Resource
{
    public function setName(string $name, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT, 'PATCH', body: ['name' => $name], repeatable: true, apiKey: $apiKey);
    }

    public function getNotifications(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_NOTIFICATIONS, apiKey: $apiKey);
    }

    public function setEmailNotification(string $category, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $wire = \array_key_exists('enabled', $body) ? ['enabled' => $body['enabled']] : [];

        return $this->call($this->fill(ApiPaths::ACCOUNT_NOTIFICATION_EMAIL, category: $category), 'PUT', body: $wire, repeatable: true, apiKey: $apiKey);
    }

    public function setPushMuted(string $workspaceId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $wire = \array_key_exists('muted', $body) ? ['muted' => $body['muted']] : [];

        return $this->call($this->fill(ApiPaths::ACCOUNT_NOTIFICATION_PUSH, workspaceId: $workspaceId), 'PUT', body: $wire, repeatable: true, apiKey: $apiKey);
    }

    public function listPushDevices(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ACCOUNT_PUSH_DEVICES, apiKey: $apiKey);
    }

    public function removePushDevice(string $deviceId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_PUSH_DEVICE, deviceId: $deviceId), 'DELETE', apiKey: $apiKey);
    }

    public function sendTestPush(?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_PUSH_DEVICES_TEST, 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function setPhoto(mixed $data, ?string $contentType = null, ?array $crop = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            ApiPaths::ACCOUNT_PHOTO,
            'PUT',
            query: $this->cropQuery($crop),
            raw: $data,
            contentType: $this->rawContentType($data, $contentType),
            repeatable: true,
            timeout: $this->uploadTimeout(),
            apiKey: $apiKey,
        );
    }

    public function removePhoto(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_PHOTO, 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function getUsername(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_USERNAME, apiKey: $apiKey);
    }

    public function checkUsername(string $username, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_USERNAME_AVAILABILITY, query: $this->query(username: $username), apiKey: $apiKey);
    }

    public function setUsername(string $username, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_USERNAME, 'PUT', body: ['username' => $username], apiKey: $apiKey);
    }

    public function listConnectedApps(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ACCOUNT_CONNECTED_APPS, apiKey: $apiKey);
    }

    public function listConnectedAppRequests(
        string $clientId,
        ?bool $failedOnly = null,
        string|array|null $statuses = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage($this->fill(ApiPaths::ACCOUNT_CONNECTED_APP_REQUESTS, clientId: $clientId), $this->requestQuery($since, $until, $failedOnly, $statuses, null), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllConnectedAppRequests(
        string $clientId,
        ?bool $failedOnly = null,
        string|array|null $statuses = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll($this->fill(ApiPaths::ACCOUNT_CONNECTED_APP_REQUESTS, clientId: $clientId), $this->requestQuery($since, $until, $failedOnly, $statuses, null), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateConnectedAppRequests(
        string $clientId,
        ?bool $failedOnly = null,
        string|array|null $statuses = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages($this->fill(ApiPaths::ACCOUNT_CONNECTED_APP_REQUESTS, clientId: $clientId), $this->requestQuery($since, $until, $failedOnly, $statuses, null), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function revokeConnectedApp(string $clientId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_CONNECTED_APP, clientId: $clientId), 'DELETE', apiKey: $apiKey);
    }

    public function endConnectedAppElevation(string $clientId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_CONNECTED_APP_ELEVATION, clientId: $clientId), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function listSessions(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ACCOUNT_SESSIONS, apiKey: $apiKey);
    }

    public function revokeSession(string $sessionId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_SESSION, sessionId: $sessionId), 'DELETE', apiKey: $apiKey);
    }

    public function revokeSessions(?bool $connectedApps = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::ACCOUNT_SESSIONS, 'DELETE', query: $this->query(connectedApps: $this->flag($connectedApps)), apiKey: $apiKey);
    }

    public function listSecurityEvents(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::ACCOUNT_SECURITY_EVENTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllSecurityEvents(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::ACCOUNT_SECURITY_EVENTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateSecurityEvents(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::ACCOUNT_SECURITY_EVENTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listPasskeys(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ACCOUNT_PASSKEYS, apiKey: $apiKey);
    }

    public function renamePasskey(string $passkeyId, string $name, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_PASSKEY, passkeyId: $passkeyId), 'PATCH', body: ['name' => $name], repeatable: true, apiKey: $apiKey);
    }

    public function removePasskey(string $passkeyId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_PASSKEY, passkeyId: $passkeyId), 'DELETE', apiKey: $apiKey);
    }

    public function listInvitations(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ACCOUNT_INVITATIONS, apiKey: $apiKey);
    }

    public function acceptInvitation(string $invitationId, ?bool $activate = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::ACCOUNT_INVITATION_ACCEPT, invitationId: $invitationId),
            'POST',
            body: $activate === null ? [] : ['activate' => $activate],
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function declineInvitation(string $invitationId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_INVITATION_DECLINE, invitationId: $invitationId), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function listOwnershipOffers(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ACCOUNT_OWNERSHIP_OFFERS, apiKey: $apiKey);
    }

    public function acceptOwnershipOffer(string $workspaceId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_OWNERSHIP_OFFER_ACCEPT, workspaceId: $workspaceId), 'POST', apiKey: $apiKey);
    }

    public function declineOwnershipOffer(string $workspaceId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ACCOUNT_OWNERSHIP_OFFER_DECLINE, workspaceId: $workspaceId), 'POST', apiKey: $apiKey);
    }
}
