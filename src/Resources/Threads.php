<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Pagination;
use Nextmail\Result\Page;

final class Threads extends Resource
{
    public function list(
        ?string $folder = null,
        ?string $query = null,
        string|array|null $labelIds = null,
        ?string $sort = null,
        string|\DateTimeInterface|null $dateFrom = null,
        string|\DateTimeInterface|null $dateTo = null,
        ?bool $fromContacts = null,
        ?bool $semantic = null,
        ?string $category = null,
        ?string $address = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(
            ApiPaths::THREADS,
            $this->listQuery($folder, $query, $labelIds, $sort, $dateFrom, $dateTo, $fromContacts, $semantic, $category, $address),
            self::PAGE_TOKEN,
            $limit,
            $cursor,
            $apiKey,
        );
    }

    public function listAll(
        ?string $folder = null,
        ?string $query = null,
        string|array|null $labelIds = null,
        ?string $sort = null,
        string|\DateTimeInterface|null $dateFrom = null,
        string|\DateTimeInterface|null $dateTo = null,
        ?bool $fromContacts = null,
        ?bool $semantic = null,
        ?string $category = null,
        ?string $address = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(
            ApiPaths::THREADS,
            $this->listQuery($folder, $query, $labelIds, $sort, $dateFrom, $dateTo, $fromContacts, $semantic, $category, $address),
            self::PAGE_TOKEN,
            $limit,
            $cursor,
            $apiKey,
        );
    }

    public function iterate(
        ?string $folder = null,
        ?string $query = null,
        string|array|null $labelIds = null,
        ?string $sort = null,
        string|\DateTimeInterface|null $dateFrom = null,
        string|\DateTimeInterface|null $dateTo = null,
        ?bool $fromContacts = null,
        ?bool $semantic = null,
        ?string $category = null,
        ?string $address = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(
            ApiPaths::THREADS,
            $this->listQuery($folder, $query, $labelIds, $sort, $dateFrom, $dateTo, $fromContacts, $semantic, $category, $address),
            self::PAGE_TOKEN,
            $limit,
            $cursor,
            $apiKey,
        );
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD, id: $id), apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function trash(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_TRASH, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function snooze(string $id, string|\DateTimeInterface $wakeAt, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::THREAD_SNOOZE, id: $id),
            'POST',
            body: ['wakeAt' => $this->instant($wakeAt)],
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function unsnooze(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_UNSNOOZE, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function mute(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_MUTE, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function unmute(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_UNMUTE, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function listMessages(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList($this->fill(ApiPaths::THREAD_MESSAGES, id: $id), apiKey: $apiKey);
    }

    public function getMessage(string $id, string $messageId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_MESSAGE, id: $id, messageId: $messageId), apiKey: $apiKey);
    }

    public function getRawMessage(string $id, string $messageId, #[\SensitiveParameter] ?string $apiKey = null): string
    {
        return $this->bytes($this->fill(ApiPaths::THREAD_MESSAGE_RAW, id: $id, messageId: $messageId), $apiKey);
    }

    public function listAttachments(string $id, string $messageId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList($this->fill(ApiPaths::THREAD_MESSAGE_ATTACHMENTS, id: $id, messageId: $messageId), apiKey: $apiKey);
    }

    public function listFileLinks(string $id, string $messageId, ?bool $includeRevoked = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::THREAD_MESSAGE_FILE_LINKS, id: $id, messageId: $messageId), $this->fileLinkQuery($includeRevoked), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllFileLinks(string $id, string $messageId, ?bool $includeRevoked = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::THREAD_MESSAGE_FILE_LINKS, id: $id, messageId: $messageId), $this->fileLinkQuery($includeRevoked), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateFileLinks(string $id, string $messageId, ?bool $includeRevoked = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::THREAD_MESSAGE_FILE_LINKS, id: $id, messageId: $messageId), $this->fileLinkQuery($includeRevoked), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listTracking(string $id, ?string $address = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList($this->fill(ApiPaths::THREAD_TRACKING, id: $id), $this->query(address: $address), apiKey: $apiKey);
    }

    public function getDelivery(string $id, ?string $address = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_DELIVERY, id: $id), query: $this->query(address: $address), apiKey: $apiKey);
    }

    public function listNotes(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList($this->fill(ApiPaths::THREAD_NOTES, id: $id), apiKey: $apiKey);
    }

    public function createNote(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_NOTES, id: $id), 'POST', body: $body, apiKey: $apiKey);
    }

    public function updateNote(string $id, string $noteId, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_NOTE, id: $id, noteId: $noteId), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function deleteNote(string $id, string $noteId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_NOTE, id: $id, noteId: $noteId), 'DELETE', apiKey: $apiKey);
    }

    public function reorderNotes(string $id, array $ids, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $envelope = $this->call(
            $this->fill(ApiPaths::THREAD_NOTES_REORDER, id: $id),
            'POST',
            body: ['ids' => array_values($ids)],
            repeatable: true,
            apiKey: $apiKey,
        );

        return Pagination::itemsOf($envelope);
    }

    public function counts(?string $address = null, ?bool $hideLabelled = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::THREADS_COUNTS, query: $this->query(address: $address, hideLabelled: $this->flag($hideLabelled)), apiKey: $apiKey);
    }

    public function summary(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_SUMMARY, id: $id), apiKey: $apiKey);
    }

    public function replySuggestions(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_REPLY_SUGGESTIONS, id: $id), apiKey: $apiKey);
    }

    public function restore(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_RESTORE, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function unsubscribe(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_UNSUBSCRIBE, id: $id), 'POST', apiKey: $apiKey);
    }

    public function getEvent(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_EVENT, id: $id), apiKey: $apiKey);
    }

    public function listSenderCategories(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::SENDER_CATEGORIES, apiKey: $apiKey);
    }

    public function setSenderCategory(string $email, string $category, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::SENDER_CATEGORY, email: $email),
            'PUT',
            body: ['category' => $category],
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function clearSenderCategory(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SENDER_CATEGORY, email: $email), 'DELETE', apiKey: $apiKey);
    }

    public function getTeam(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_TEAM, id: $id), apiKey: $apiKey);
    }

    public function assign(string $id, string $assigneeId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::THREAD_ASSIGNEE, id: $id),
            'PUT',
            body: ['assigneeId' => $assigneeId],
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function unassign(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_ASSIGNEE, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function setReplying(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_REPLYING, id: $id), 'PUT', repeatable: true, apiKey: $apiKey);
    }

    public function clearReplying(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_REPLYING, id: $id), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function markDone(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_DONE, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function reopen(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_REOPEN, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function listComments(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList($this->fill(ApiPaths::THREAD_COMMENTS, id: $id), apiKey: $apiKey);
    }

    public function createComment(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_COMMENTS, id: $id), 'POST', body: $body, apiKey: $apiKey);
    }

    public function updateComment(string $id, string $commentId, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::THREAD_COMMENT, id: $id, commentId: $commentId),
            'PATCH',
            body: $body,
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function deleteComment(string $id, string $commentId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::THREAD_COMMENT, id: $id, commentId: $commentId), 'DELETE', apiKey: $apiKey);
    }

    private function fileLinkQuery(?bool $includeRevoked): array
    {
        return $this->query(includeRevoked: $this->flag($includeRevoked));
    }

    private function listQuery(
        ?string $folder,
        ?string $query,
        string|array|null $labelIds,
        ?string $sort,
        string|\DateTimeInterface|null $dateFrom,
        string|\DateTimeInterface|null $dateTo,
        ?bool $fromContacts,
        ?bool $semantic,
        ?string $category,
        ?string $address,
    ): array {
        return $this->query(
            folder: $folder,
            query: $query,
            labelIds: $this->joined($labelIds),
            sort: $sort,
            dateFrom: $this->instant($dateFrom),
            dateTo: $this->instant($dateTo),
            fromContacts: $this->flag($fromContacts),
            semantic: $this->flag($semantic),
            category: $category,
            address: $address,
        );
    }
}
