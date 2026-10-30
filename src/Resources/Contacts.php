<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Pagination;
use Nextmail\Internal\Protocol;
use Nextmail\Result\Page;
use Nextmail\Result\PeoplePage;

final class Contacts extends Resource
{
    public function list(
        ?string $source = null,
        ?string $audienceId = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::CONTACTS, $this->listQuery($source, $audienceId, $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(
        ?string $source = null,
        ?string $audienceId = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::CONTACTS, $this->listQuery($source, $audienceId, $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(
        ?string $source = null,
        ?string $audienceId = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::CONTACTS, $this->listQuery($source, $audienceId, $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT, email: $email), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONTACTS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $email, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT, email: $email), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT, email: $email), 'DELETE', apiKey: $apiKey);
    }

    public function setAudiences(string $email, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_AUDIENCES, email: $email), 'PUT', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function listPeople(
        ?string $q = null,
        ?string $email = null,
        ?string $sort = null,
        ?bool $blocked = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): PeoplePage {
        $query = Pagination::pageQuery($this->peopleQuery($q, $email, $sort, $blocked), self::CURSOR, $limit, $cursor);
        $envelope = $this->call(ApiPaths::CONTACTS_PEOPLE, query: $query, apiKey: $apiKey);
        $nextCursor = Pagination::cursorOf($envelope['nextCursor'] ?? null);

        return new PeoplePage(
            Pagination::itemsOf($envelope),
            Pagination::hasMore($envelope, $nextCursor),
            $nextCursor,
            ($envelope['seen'] ?? null) === true,
        );
    }

    public function listAllPeople(
        ?string $q = null,
        ?string $email = null,
        ?string $sort = null,
        ?bool $blocked = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::CONTACTS_PEOPLE, $this->peopleQuery($q, $email, $sort, $blocked), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iteratePeople(
        ?string $q = null,
        ?string $email = null,
        ?string $sort = null,
        ?bool $blocked = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::CONTACTS_PEOPLE, $this->peopleQuery($q, $email, $sort, $blocked), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function save(string $email, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT, email: $email), 'PUT', body: $this->payload($body), repeatable: true, apiKey: $apiKey);
    }

    public function deleteMany(array $emails, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONTACTS_BATCH_DELETE, 'POST', body: ['emails' => array_values($emails)], repeatable: true, apiKey: $apiKey);
    }

    public function setPhoto(string $email, mixed $data, ?string $contentType = null, ?array $crop = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::CONTACT_PHOTO, email: $email),
            'PUT',
            query: $this->cropQuery($crop),
            raw: $data,
            contentType: $this->rawContentType($data, $contentType),
            repeatable: true,
            timeout: $this->uploadTimeout(),
            apiKey: $apiKey,
        );
    }

    public function removePhoto(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_PHOTO, email: $email), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function block(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_BLOCK, email: $email), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function unblock(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_BLOCK, email: $email), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function listThreads(string $email, ?string $q = null, ?string $sort = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::CONTACT_THREADS, email: $email), $this->query(q: $q, sort: $sort), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllThreads(string $email, ?string $q = null, ?string $sort = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::CONTACT_THREADS, email: $email), $this->query(q: $q, sort: $sort), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateThreads(string $email, ?string $q = null, ?string $sort = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::CONTACT_THREADS, email: $email), $this->query(q: $q, sort: $sort), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listEvents(string $email, ?string $name = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::CONTACT_EVENTS, email: $email), $this->query(name: $name), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllEvents(string $email, ?string $name = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::CONTACT_EVENTS, email: $email), $this->query(name: $name), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateEvents(string $email, ?string $name = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::CONTACT_EVENTS, email: $email), $this->query(name: $name), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function activity(
        string $email,
        ?int $minutes = null,
        string|\DateTimeInterface|null $from = null,
        string|\DateTimeInterface|null $to = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(
            $this->fill(ApiPaths::CONTACT_ACTIVITY, email: $email),
            query: $this->query(minutes: $minutes, grain: $grain, offsetMinutes: $offsetMinutes, from: $this->instant($from), to: $this->instant($to)),
            apiKey: $apiKey,
        );
    }

    public function listCards(
        ?string $email = null,
        ?bool $withoutEmail = null,
        ?string $kind = null,
        ?string $groupId = null,
        ?string $addressBook = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::CONTACT_CARDS, $this->cardQuery($email, $withoutEmail, $kind, $groupId, $addressBook), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllCards(
        ?string $email = null,
        ?bool $withoutEmail = null,
        ?string $kind = null,
        ?string $groupId = null,
        ?string $addressBook = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::CONTACT_CARDS, $this->cardQuery($email, $withoutEmail, $kind, $groupId, $addressBook), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateCards(
        ?string $email = null,
        ?bool $withoutEmail = null,
        ?string $kind = null,
        ?string $groupId = null,
        ?string $addressBook = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::CONTACT_CARDS, $this->cardQuery($email, $withoutEmail, $kind, $groupId, $addressBook), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAddressBooks(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::ADDRESS_BOOKS, apiKey: $apiKey);
    }

    public function setAddressBookMember(string $id, string $memberId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ADDRESS_BOOK_MEMBER, id: $id, memberId: $memberId), 'PUT', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function removeAddressBookMember(string $id, string $memberId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::ADDRESS_BOOK_MEMBER, id: $id, memberId: $memberId), 'DELETE', apiKey: $apiKey);
    }

    public function getCard(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_CARD, id: $id), apiKey: $apiKey);
    }

    public function createCard(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONTACT_CARDS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function updateCard(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_CARD, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function deleteCard(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_CARD, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function findDuplicateCards(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONTACT_CARD_DUPLICATES, apiKey: $apiKey);
    }

    public function mergeCards(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_CARD_MERGE, id: $id), 'POST', body: $body, apiKey: $apiKey);
    }

    public function listBirthdays(
        string|\DateTimeInterface $from,
        string|\DateTimeInterface $to,
        ?string $timezone = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->fetchList(
            ApiPaths::CONTACT_BIRTHDAYS,
            $this->query(from: $this->instant($from), to: $this->instant($to), timezone: $timezone),
            apiKey: $apiKey,
        );
    }

    public function importVcf(mixed $data, ?string $filename = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            ApiPaths::CONTACT_IMPORTS,
            'POST',
            query: $this->query(filename: $filename),
            raw: $data,
            contentType: Protocol::CONTENT_TYPES['VCARD'],
            apiKey: $apiKey,
        );
    }

    public function listImports(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::CONTACT_IMPORTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllImports(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::CONTACT_IMPORTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateImports(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::CONTACT_IMPORTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getImport(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_IMPORT, id: $id), apiKey: $apiKey);
    }

    public function undoImport(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONTACT_IMPORT_UNDO, id: $id), 'POST', apiKey: $apiKey);
    }

    private function listQuery(?string $source, ?string $audienceId, ?string $q): array
    {
        return $this->query(source: $source, q: $q, audienceId: $audienceId);
    }

    private function peopleQuery(?string $q, ?string $email, ?string $sort, ?bool $blocked): array
    {
        return $this->query(q: $q, email: $email, sort: $sort, blocked: $this->flag($blocked));
    }

    private function cardQuery(?string $email, ?bool $withoutEmail, ?string $kind, ?string $groupId, ?string $addressBook): array
    {
        return $this->query(email: $email, withoutEmail: $this->flag($withoutEmail), kind: $kind, groupId: $groupId, addressBook: $addressBook);
    }
}
