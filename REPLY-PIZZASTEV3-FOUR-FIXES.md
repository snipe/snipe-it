Thanks for the four reports. All four are now fixed on develop and have draft advisories open. You're added as a collaborator on each so you can see progress through the embargo window and watch the CVE requests resolve.

**Login failed-redirect open-redirect** (GHSA-qxw3-vq74-gr44): Both failure branches now route url()->previous() through Helper::sameOriginUrl() with route('login') as the fallback. Same primitive as the earlier SAML RelayState fix (GHSA-579m-9gf4-28jp), different sink. Fix commit 8c33d8325e.

**Maintenance mass-assignment on completed_by** (GHSA-chm5-cq2h-7v47): completed_by added to the except() list on the PATCH update path. The dedicated complete() action is now the only writer for the attribution column. Fix commit bd70366e25.

**Location selectlist Referer gate** (GHSA-25xg-93w8-xqg5): The Referer branch is gone. The endpoint accepts either view.selectlists or self.edit_location via canAny(), server-chosen with no header input. Fix commit 53081ba572.

**Concurrent checkin audit duplication** (GHSA-6xp4-g4wc-2442): The checkin critical section is wrapped in DB::transaction with lockForUpdate on the asset row and a re-check of assignedTo against the locked snapshot. Mirrors the checkout path's lock pattern. Fix commit e788816c10.

If you want to retest, develop carries all four. We'd appreciate holding public disclosure on each one until the advisory is published.
