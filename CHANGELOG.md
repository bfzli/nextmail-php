# Changelog

## 0.0.1

The first release of the PHP package. It has a method for every one of the 746 methods of the
TypeScript SDK, in 53 namespaces, each under its TypeScript name, and a parity check in the
package's own build proves that every one sends the same request as its TypeScript twin, retries
the same way and returns the same shape.

- `Nextmail\Nextmail` has a property for every namespace, from `emails`, `threads` and `templates`
  to `automations`, `bookings` and `connectedMailboxes`. A request body is an associative array
  whose keys keep the API's camelCase names, the options of a call are named arguments such as
  `idempotencyKey:` and `limit:`, and a response comes back as the decoded associative array.
- `new Nextmail()` and `Nextmail::createClient()` take `apiKey:` or `accessToken:`, and
  `accessToken:` also takes a callable that returns a token, called before every request. Anything
  you leave out is read from `NEXTMAIL_API_KEY`, `NEXTMAIL_ACCESS_TOKEN` and `NEXTMAIL_BASE_URL`,
  and `baseUrl:`, `timeout:`, `maxRetries:`, `headers:`, `userAgent:` and `httpClient:` set the
  rest. Every method takes `apiKey:`, or `inboxToken:` on `tempMail`, to act with another
  credential for one call.
- Every workspace is the same kind, the one that holds the free address included. That address
  sends only the mail a person writes in the app, so a send from it with an API key or an access
  token is refused with `from_address_forbidden`.
- `Nextmail::init()`, `Nextmail::getClient()` and `Nextmail::resetClient()` manage one shared
  client, and `Nextmail::createTempMail()` opens disposable inboxes with no credential.
- Every paginated resource has `list`, which returns one `Nextmail\Result\Page` with `items`,
  `hasMore` and `nextCursor`, `listAll`, which returns every item as an array, and `iterate`, which
  returns a Generator that fetches the next page only when it gets there.
- An API refusal throws `Nextmail\Exception\ApiException` or its subclass for the error type, such
  as `NotFoundException`, `ValidationException` or `RateLimitException`, with `status`, `type`,
  `errorCode`, `param`, `docUrl`, `requestId`, `retryAfterSeconds` and `fields`, and methods such
  as `isValidation()`, `isStepUpRequired()` and `isRetryable()`. No response at all throws
  `NetworkException`, with `isTimeout()` when the deadline passed, and a mistake in the call itself
  throws `InvalidArgumentException` before anything is sent. Every exception the package throws
  implements `Nextmail\Exception\NextmailException`.
- Reads, sends and every write that is safe to repeat are retried on 408, 500, 502, 503 and 504 with
  backoff, and on a 429 only when its `Retry-After` is a minute or less. A send carries an
  idempotency key that its retries reuse, so a retry never sends a second message. `timeout:` bounds
  a whole attempt, and uploads wait at least ten minutes.
- `Nextmail::verifyWebhookSignature()` checks a delivery in constant time, refuses one more than
  five minutes old and returns the decoded event. It reads the signature from an array of headers
  in any case, from `$_SERVER`, from a Symfony or Laravel header bag, or from a PSR-7 message.
- The helpers of the TypeScript SDK are here too, such as `Nextmail::toBase64()` and
  `Nextmail::resolveLanguage()`, and every value set it exports is a class in `Nextmail\Constants`,
  such as `WebhookEvents` and `ApiScopes`, with a `values()` method for the whole set.
- Requests go through one cURL handle per client, which keeps its connection open between requests
  and opens a new one after `pcntl_fork`. `Nextmail\Http\Psr18HttpClient` sends them through
  Guzzle, Symfony HttpClient or any other PSR-18 client instead, and anything that implements
  `Nextmail\Http\HttpClient` can take the place of either, which is how a test runs without a
  network.
- Credentials stay out of sight: every parameter that carries one is marked
  `#[\SensitiveParameter]`, no dump of a client or a request shows one, and the client never sends
  one over plain `http:` to anything but this machine.
- When a newer version is on Packagist, the client says so once, on the command line and only on a
  terminal. `disableUpdateNotice: true` or `NEXTMAIL_DISABLE_UPDATE_NOTICE=1` turns that off.
- It needs PHP 8.2 or later with the curl and json extensions, and nothing else.
- API keys begin `nm_live_` or `nm_test_`, and temporary inbox tokens `nm_inbox_`. The client
  refuses a key of any other shape.
- The six image uploads, `account->setPhoto`, `contacts->setPhoto`, `domains->setAddressPhoto`,
  `bookings->uploadBackground`, `branding->uploadImage` and `templates->uploadImage`, take images up
  to 100 MB and a `crop:` argument, an array of `x`, `y`, `width` and `height` as fractions of the
  image from 0 to 1, and wait at least ten minutes, as `files->upload` does.
- `emails->listEventsByMessageId`, `listAllEventsByMessageId` and `iterateEventsByMessageId` read
  the event trail of a sent email found by the Message-ID header it went out with, for a caller
  that holds that header and not the `msg_` id, such as a reply or a bounce report that quotes it.
  The Message-ID is the first argument, with or without its angle brackets. They take `address:`,
  `limit:` and `cursor:`, and a Message-ID that no message the key reaches went out with is a 404.
- `providerImports->list`, `listAll` and `iterate` take `source:` (`ProviderImportProviders`),
  `status:` (`ImportHistoryStatuses`) and `search:`, up to 320 characters, the filters
  `imports->list` takes. An import from a provider never pauses, so `status: 'paused'` answers an
  empty page.
- `emails->listEvents`, `listAllEvents` and `iterateEvents` take `messageId:`, 1 to 998 characters:
  the trail answers only when the send went out with that Message-ID header, with or without its
  angle brackets, and is a 404 otherwise. The send id is still required.
- `files->createLink` takes `reuse:`. `true` hands back the working public link the file already
  has, with its own domain and download count, instead of making another, and a file with none
  gets a new one. A link handed back answers 200 and a new one 201.
- `keys->create`, `update` and `delete`, `keys->rotate` for any key but the caller, and
  `workspaces->offerOwnership`, `withdrawOwnershipOffer`, `account->acceptOwnershipOffer` and
  `declineOwnershipOffer` refuse an API key with 403 `console_only`. The console confirms these
  changes with a verification code, which a key cannot give, so they are made there. A key still
  rotates its own secret with `keys->rotate` or `me->rotate`, and revokes keys with `keys->revoke`.
- `appHost->get`, `set` and `verify` return `sender`: where the emails sent to the people of the
  workspace come from, an array with `address`, `domain` and `waitingOn`. `waitingOn` is `logo` or
  `signing` (`AppHostSenderWaits`) until they come from `noreply@` the domain of the live web app
  address, then null. `sender` is null on the free plan and until an address on a verified domain
  of the workspace is live.
- Each address from `addresses->list`, `listAll` and `iterate` carries `role` (`AddressRoles`):
  `owner` on every address for an API key, and `member` or `viewer` for an app a member connected. A
  key narrowed to particular addresses or domains lists only the addresses and domains it covers,
  and the free address of the person the key acts for is listed, with `role` `owner`, by a key of
  the workspace it belongs to.
- `chats->listMessages`, `listAllMessages` and `iterateMessages` read the messages of a chat, from
  the first unless `order:` is `desc` (`ChatMessageOrders`). Each message has its `text` and its
  `parts` (`ChatMessagePartTypes`): the words, the tools the assistant called with their
  arguments, results and status (`ChatToolCallStatuses`), and the files. A tool result the caller
  may not read comes back redacted.
- `chats->sendMessage` says something in a chat, or starts one under a new id, and returns the
  turn once the assistant has answered. `status` (`ChatTurnStatuses`) is `awaiting_approval` when
  a call that changes something waits in `pendingToolCalls`, which `chats->approveToolCall`, with
  optional `args`, or `chats->denyToolCall` answers. `'regenerate' => true` answers the last
  message again, and inline `attachments` are encoded as they are for `emails->send`.
  `chats->stopTurn` stops the assistant (`ChatStopStatuses`), and a stopped turn says why in
  `stopReason` (`ChatStopReasons`). A turn runs for at most 240 seconds, so `sendMessage`,
  `approveToolCall` and `denyToolCall` wait up to 5 minutes by default, or the client's `timeout`
  when that is longer, and take `timeout:` for one call, where 0 waits as long as it takes. None
  of them is retried. The refusals are `chat_busy`, `approval_pending`, `tool_not_offered`,
  `ai_quota_exceeded`, `ai_not_configured` and `assistant_unavailable`.
- `members->getDirectorySync` reads directory sync (SCIM), and `members->connectDirectorySync`
  turns it on and returns the token once. `members->disconnectDirectorySync` turns it off,
  `members->listDirectoryPeople` reads who the directory synced (`DirectoryPersonStates`), and
  `members->setDirectoryDefaultRole` and `setDirectoryGroupRole` choose the roles it gives, or
  null for none. Only the owner or a role holding `workspace:manage` reaches them, every change asks
  an OAuth access token for a verification code, and the refusals are `plan_required`,
  `role_not_found` and `directory_sync_not_connected`.
- `security->getPolicy` reads whether the workspace requires two-factor sign-in and whether the
  person behind the client meets it, with no scope. `security->updatePolicy` sets
  `requireTwoFactor`, with `members:write` and a verification code.
- `workspaces->getOwnershipOffer`, `offerOwnership` and `withdrawOwnershipOffer` let the owner offer
  the workspace to one of its members, and `account->listOwnershipOffers`, `acceptOwnershipOffer`
  and `declineOwnershipOffer` answer the offers made to the person. Offering and accepting ask for
  a verification code. The refusals are `ownership_offer_not_found`, `ownership_not_eligible`,
  `ownership_changed`, `domain_moving`, `two_factor_required` and `workspace_allowance_reached`.
- `account->setName` changes the name of the person. `account->listPushDevices`,
  `removePushDevice` and `sendTestPush` read the phones that get the person's notifications
  (`PushPlatforms`), stop one, and send a test. `account->endConnectedAppElevation` makes a
  connected app ask for verification codes again.
- `dnsConnections->start` returns the link that connects a Cloudflare account to the workspace in a
  browser. It asks an OAuth access token for a verification code, and a server that cannot connect
  a provider answers `dns_unavailable`.
- `domains->createMailAppProfileLink` makes a one-time link that sets an address up on an Apple
  device. It needs `members:write` and a verification code, and past 10 links an hour it is
  `profile_link_rate_limited`. `domains->startGravatarPublish` returns the link that publishes the
  photo of an address to Gravatar, refused with `photo_required` and `gravatar_not_configured`.
- `threads->setReplying` and `clearReplying` show the team who is writing a reply.
  `threads->listTracking` reads the tracking report of every tracked message sent in a thread, and
  `threads->getDelivery` counts what bounced, was refused or was held back, both narrowed by
  `address:`. `threads->listFileLinks`, `listAllFileLinks` and `iterateFileLinks` read the
  download links one message carried, with `includeRevoked:`. `threads->counts` takes
  `hideLabelled:`.
- `senders->getAvatar` fetches the picture of a sender as a string of bytes, and `senders->get`
  reports `avatarUrl` and `avatarKind` (`SenderAvatarKinds`).
- `emails->send` and `sendBatch` take `isForward`, `originalMessage`, the quoted history of a
  forward or a reply, and `encryption`, an array with `format` set to `pgp-mime`, `sealedAt` and
  `sealedTo`, for a message you sealed yourself with OpenPGP. `emails->translate` takes
  `skipQuoted` and reports `quotedHistoryKept`.
- `emails->listEvents`, `listAllEvents`, `iterateEvents` and `getTracking` and the `tracking` opens
  and clicks methods take `address:`. The `tracking->list` methods take `offsetMinutes:`, and
  `tracking->getStats` reports `downloads`, the files that went out as download links and how often
  they were fetched.
- `templates->update`, `replaceContent` and `publish` take `expectedUpdatedAt`, the `updatedAt` of
  the version you read, and refuse a change saved in between with `version_conflict`. Every template
  version reports `updatedAt`.
- `drafts->create` and `update` take `attachments`, up to 20 files inline or by `fileId`, encoded
  as they are for `emails->send`, and the attachments `drafts->get` returns report `fileId`.
- Filters: `ruleIds:` on the `rules->listRuns` methods, `audienceId:` on the `contacts->list`
  methods, `from:` and `to:` on `contacts->activity`, `inactiveDays:` on the
  `audiences->listContacts` methods, `since:` and `until:` on `audiences->growth`,
  `forms->analytics` and `bookings->analytics`, `since:` on `broadcasts->analytics` and
  `broadcasts->stats`, `source:`, `status:` (`ImportHistoryStatuses`) and `search:` on the
  `imports->list` methods, and `from:` on the `signatures->list` methods.
- `contacts->setAudiences` and `audiences->addContact` take `createContact`, which saves an address
  that is not a contact yet as one first and then needs `contacts:write`. Through an app a member
  connected, an address another member saved is a 409 `contact_exists` there and on
  `contacts->save`.
- Scopes: `addresses->list`, `listAll` and `iterate` need `emails:read`, or `emails:send` in its
  place. The `audiences->listContacts` methods need `contacts:read` as well as `audiences:read`.
  `emails->compose`, `rewrite`, `suggestSubject` and `translate` take `drafts:write` in place of
  `emails:send`. `domains->getMailAppSettings` and `listAppPasswords` need `threads:read`, and
  `domains->updateMailAppSettings` needs `threads:read` and `domains:write`.
  `domains->createAddress` asks an OAuth access token for a verification code when it chooses where
  the mail goes or deletion on expiry.
- An attachment given as an array with `url` and optionally `filename` and `contentType`, a file at
  an https address, is sent as it is.
- `domains->createAddress` and `domains->updateAddress` take `expiresAt` and `onExpiry`
  (`AddressExpiryActions`), and every address reports them with `expiredAt`. From its `expiresAt` an
  address takes no mail and sends none, a send from it is refused with 403 `address_expired`, and
  within a minute it is switched off, or deleted with the conversations delivered to it when
  `onExpiry` is `delete`. `WebhookEvents::ADDRESS_EXPIRED` is the event `address.expired`.
- `DomainAddressDestinations` includes `WEBHOOK` and `GROUP`. The same two methods take `webhookId`
  for a webhook destination, `tapWebhookIds` to copy every message to up to 5 endpoints, and
  `groupPosting` (`AddressGroupPostingPolicies`) and `groupKeepCopy` for a group, and every address
  reports them. The refusals are `webhook_not_found` and `too_many_taps`.
- `WebhookEvents::EMAIL_ROUTED` is the event `email.routed`: a message that arrived at an address
  whose destination is `webhook`, or that a route of its domain sent to a webhook, was kept for 30
  days instead of being filed. It goes only to the endpoint the address or route names and to the
  taps of the address, and always carries `content` and `raw`. `routedBy` says which sent it, one
  of `WebhookRoutedSources`. An `email.received` event carries `tap`, true when the endpoint gets
  the message as a tap of the address rather than through its subscription.
- `domains->testRoute` answers which step decides mail to an address, without sending anything:
  an address that exists, the primary of an alias, a pattern route, the catch-all or none
  (`AddressRouteTestSteps`), with the route that decided and where the mail would end up.
- `domains->listRoutes`, `listAllRoutes` and `iterateRoutes` read the pattern routes of a domain
  in the order they are tried, and `domains->createRoute`, `getRoute`, `updateRoute` and
  `deleteRoute` manage them. A route catches mail to addresses nobody created whose local part
  matches its `pattern`, such as `support-*`, and delivers it to an address, forwards it once the
  destination confirms, posts it to a webhook as `email.routed` or reads it on another domain
  (`AddressRouteActions`). `active` and `inactiveReason` (`AddressRouteInactiveReasons`) say
  whether a route takes mail now. A domain holds at most 100 routes.
- `domains->listGroupMembers`, `listAllGroupMembers` and `iterateGroupMembers` read the group
  members of a group address, and `domains->addGroupMembers` and `removeGroupMember` change them.
  A group member is an address of the workspace or an address at another provider, which
  confirms by email first (`GroupMemberKinds`). A group holds at most 1,000 group members and
  groups nest at most 3 deep.
- `domains->update` takes `aliasOf`, which makes the domain an alias of another domain of the
  workspace, and every domain reports `aliasOf` and `aliases`. The refusals are
  `alias_not_allowed`, `alias_chain` and `alias_has_addresses`.
- `domains->updateAddressLimits` takes `receiving.storageBytes`, a storage quota for one address
  from 1 MiB to 1 TiB. A message that would take the address past it gets a permanent bounce
  (5.2.2), and deleting mail for good makes room again. `domains->getAddressLimits` reports what
  the address keeps in `usage.storage`, with `bytes` and `messages`.
- `webhooks->listDeadLetters`, `listAllDeadLetters` and `iterateDeadLetters` read the events an
  endpoint gave up on: each event whose last automatic attempt failed, with how many times it was
  tried, the last answer and that attempt. `status:` reads the `open` ones by default, or
  `replayed`, `discarded` or `all` (`WebhookDeadLetterFilters`). A dead letter is kept 30 days.
- `webhooks->replayDeadLetters` sends up to 100 open dead letters again in one call, the named ones
  or the oldest, and answers with an `outcome` for each (`WebhookDeadLetterReplayOutcomes`).
  `webhooks->discardDeadLetter` closes one without sending it, and one already replayed is 409
  `dead_letter_resolved`.
- `webhooks->create` and `webhooks->update` take `retryPolicy` (`WebhookRetryPolicies`): `standard`
  tries a failed delivery up to 8 times over about 27 and a half hours, and `extended` up to 16
  times over about 3 days. They also take `'includeRaw' => true`, which gives every `email.received`
  event a link to the message source as `data.raw` and needs `threads:read`.
- `threads->getRawMessage` downloads the source of one message as a string of `message/rfc822`
  bytes, ready to save as an `.eml` file: the message byte for byte as it arrived when the address
  had `keepOriginal` on, and otherwise a source rebuilt from the stored message. The
  `X-Message-Source` response header says which, one of `RawMessageSources`.
- `domains->createAddress` and `domains->updateAddress` take `'keepOriginal' => true`, which keeps
  each message the address receives byte for byte as it arrived, and every address reports
  `keepOriginal`.
- `domains->getAddressLimits` and `domains->updateAddressLimits` read and change what one address
  may send and receive: a hold that pauses or disables sending or receiving, caps per hour, per 24
  hours and per month on messages and recipients, recipients per message, and lists of allowed and
  blocked recipients and allowed senders, with the usage so far. `AddressHolds` lists the holds.
- `domains->get` and `domains->update` give each DNS record `found`, what public DNS answers at
  that name now, and `problem`, an array with a `code` from `DomainRecordProblems` and a `message`
  to show a person.
- `domains->update` takes `'autodiscovery' => true`, which offers the SRV and TXT records that let
  mail, calendar and contacts apps find the servers from an address on the domain alone, listed in
  `autodiscoveryRecords`.
- `webhooks->create` and `webhooks->update` take `'includeContent' => true`, which puts the message
  into every `email.received` event as `data.content`: the text, the HTML up to 512 KiB and each
  attachment with a link that downloads it for an hour. Turning it on needs `threads:read`.
- A connected mailbox can be the sender of `emails->send` with an API key, of broadcasts,
  automations and sign-up forms, and a key or an app can send from the free address of the person
  it acts for. Only that person may send as a free address.
- `threads->counts()` leaves labelled mail out of `team.assigned` and `team.unassigned`, as the
  inbox does, unless the person has chosen to show labelled mail in the inbox.
- `billing->get()` reports `usage.addressChecks`, the deep address checks used this calendar month
  against what the plan includes, and `billing->listPlans()` each plan's `monthlyAddressChecks`.
  `tools->checkAddress()` and `tools->checkAddresses()` with `deep` first use the deep checks the
  plan includes each month (10 on Free, 100 on Starter, 500 on Business, 1,000 on Enterprise), then
  pay as you go at $1.50 per 100 addresses.
- An automation branch can check the contact's address: `['kind' => 'address_check', 'mailbox' =>
  ..., 'accept' => ...]`, with `accept` from `Nextmail\Constants\AutomationAddressAccepts`.
- A send leaves out an address whose domain takes no mail, and one the check on sending finds has no
  mailbox. Each shows as `suppressed`, with an `email.suppressed` webhook that names the reason,
  never as a bounce.
- Forms check the address of every sign-up: `forms->subscribe` refuses one whose domain takes no
  mail with the field error `undeliverable`. `'refuseDisposable' => true` in `settings` also
  refuses throwaway addresses (`disposable`), `'checkMailbox' => true` runs a deep check on every
  sign-up and refuses a missing mailbox (`mailbox_not_found`), and a refused address that looks
  like a typo carries `suggestion`.
- `domains`, `members`, `keys`, `webhooks` and `rules` take `q:` on `list`, `listAll` and `iterate`,
  and `connectedMailboxes->list` takes it too. It narrows the list to what matches the search,
  ignoring case and accents and allowing for a typo when nothing matches exactly.
- `rules->stats()` reads how the rules did inside a window: the messages they matched, the ones
  with a failed action, a series of buckets, the matches of each rule, the actions they took, the
  failures and the senders they matched most. It takes `ruleIds:`, `since:`, `until:`, `grain:`
  and `offsetMinutes:`, like `webhooks->stats()`.
