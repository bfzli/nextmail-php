<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Domains extends Resource
{
    public function list(?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::DOMAINS, $this->query(q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::DOMAINS, $this->query(q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::DOMAINS, $this->query(q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN, id: $id), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::DOMAINS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function verify(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_VERIFY, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function getLogo(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_LOGO, id: $id), apiKey: $apiKey);
    }

    public function setLogo(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_LOGO, id: $id), 'PUT', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function removeLogo(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_LOGO, id: $id), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function setLogoCertificate(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_LOGO_CERTIFICATE, id: $id), 'PUT', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function removeLogoCertificate(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_LOGO_CERTIFICATE, id: $id), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function listAddresses(string $id, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::DOMAIN_ADDRESSES, id: $id), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllAddresses(string $id, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::DOMAIN_ADDRESSES, id: $id), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateAddresses(string $id, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::DOMAIN_ADDRESSES, id: $id), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function createAddress(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESSES, id: $id), 'POST', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function getAddress(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function updateAddress(string $id, string $addressId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS, id: $id, addressId: $addressId), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function setAddressPhoto(
        string $id,
        string $addressId,
        mixed $data,
        ?string $contentType = null,
        ?array $crop = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(
            $this->fill(ApiPaths::DOMAIN_ADDRESS_PHOTO, id: $id, addressId: $addressId),
            'PUT',
            query: $this->cropQuery($crop),
            raw: $data,
            contentType: $this->rawContentType($data, $contentType),
            repeatable: true,
            timeout: $this->uploadTimeout(),
            apiKey: $apiKey,
        );
    }

    public function removeAddressPhoto(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_PHOTO, id: $id, addressId: $addressId), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function startGravatarPublish(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_PHOTO_GRAVATAR, id: $id, addressId: $addressId), 'POST', apiKey: $apiKey);
    }

    public function deleteAddress(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS, id: $id, addressId: $addressId), 'DELETE', apiKey: $apiKey);
    }

    public function listAddressForwards(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_FORWARDS, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function addAddressForwards(string $id, string $addressId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_FORWARDS, id: $id, addressId: $addressId), 'POST', body: $body, apiKey: $apiKey);
    }

    public function updateAddressForward(string $id, string $addressId, string $forwardId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::DOMAIN_ADDRESS_FORWARD, id: $id, addressId: $addressId, forwardId: $forwardId),
            'PATCH',
            body: $patch,
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function deleteAddressForward(string $id, string $addressId, string $forwardId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_FORWARD, id: $id, addressId: $addressId, forwardId: $forwardId), 'DELETE', apiKey: $apiKey);
    }

    public function resendAddressForwardConsent(string $id, string $addressId, string $forwardId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_FORWARD_RESEND, id: $id, addressId: $addressId, forwardId: $forwardId), 'POST', apiKey: $apiKey);
    }

    public function listAddressMembers(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_MEMBERS, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function getAddressLogin(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_LOGIN, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function setAddressLogin(string $id, string $addressId, #[\SensitiveParameter] array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_LOGIN, id: $id, addressId: $addressId), 'PUT', body: $body, apiKey: $apiKey);
    }

    public function deleteAddressLogin(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_LOGIN, id: $id, addressId: $addressId), 'DELETE', apiKey: $apiKey);
    }

    public function getMailAppSettings(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_MAIL_APPS, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function updateMailAppSettings(string $id, string $addressId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_MAIL_APPS, id: $id, addressId: $addressId), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function getAddressLimits(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_LIMITS, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function updateAddressLimits(string $id, string $addressId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_LIMITS, id: $id, addressId: $addressId), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function listAppPasswords(string $id, string $addressId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_APP_PASSWORDS, id: $id, addressId: $addressId), apiKey: $apiKey);
    }

    public function createAppPassword(string $id, string $addressId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_APP_PASSWORDS, id: $id, addressId: $addressId), 'POST', body: $body, apiKey: $apiKey);
    }

    public function updateAppPassword(string $id, string $addressId, string $passwordId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::DOMAIN_ADDRESS_APP_PASSWORD, id: $id, addressId: $addressId, passwordId: $passwordId),
            'PATCH',
            body: $patch,
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function deleteAppPassword(string $id, string $addressId, string $passwordId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_APP_PASSWORD, id: $id, addressId: $addressId, passwordId: $passwordId), 'DELETE', apiKey: $apiKey);
    }

    public function sendMailAppSetup(string $id, string $addressId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_MAIL_APP_SETUP, id: $id, addressId: $addressId), 'POST', body: $body, apiKey: $apiKey);
    }

    public function createMailAppProfileLink(string $id, string $addressId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_MAIL_APP_PROFILE_LINK, id: $id, addressId: $addressId), 'POST', body: $body, apiKey: $apiKey);
    }

    public function getDns(string $id, ?bool $refresh = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_DNS, id: $id), query: $this->query(refresh: $refresh), apiKey: $apiKey);
    }

    public function setDnsZone(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_DNS, id: $id), 'PUT', body: $body, apiKey: $apiKey);
    }

    public function syncDns(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_DNS_SYNC, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function listRoutes(string $id, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::DOMAIN_ROUTES, id: $id), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllRoutes(string $id, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::DOMAIN_ROUTES, id: $id), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateRoutes(string $id, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::DOMAIN_ROUTES, id: $id), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function createRoute(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ROUTES, id: $id), 'POST', body: $body, apiKey: $apiKey);
    }

    public function getRoute(string $id, string $routeId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ROUTE, id: $id, routeId: $routeId), apiKey: $apiKey);
    }

    public function updateRoute(string $id, string $routeId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ROUTE, id: $id, routeId: $routeId), 'PATCH', body: $patch, apiKey: $apiKey);
    }

    public function deleteRoute(string $id, string $routeId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ROUTE, id: $id, routeId: $routeId), 'DELETE', apiKey: $apiKey);
    }

    public function testRoute(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ROUTE_TEST, id: $id), 'POST', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function listGroupMembers(string $id, string $addressId, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::DOMAIN_ADDRESS_GROUP_MEMBERS, id: $id, addressId: $addressId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllGroupMembers(string $id, string $addressId, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::DOMAIN_ADDRESS_GROUP_MEMBERS, id: $id, addressId: $addressId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateGroupMembers(string $id, string $addressId, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::DOMAIN_ADDRESS_GROUP_MEMBERS, id: $id, addressId: $addressId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function addGroupMembers(string $id, string $addressId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_GROUP_MEMBERS, id: $id, addressId: $addressId), 'POST', body: $body, apiKey: $apiKey);
    }

    public function removeGroupMember(string $id, string $addressId, string $memberId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::DOMAIN_ADDRESS_GROUP_MEMBER, id: $id, addressId: $addressId, memberId: $memberId), 'DELETE', apiKey: $apiKey);
    }
}
