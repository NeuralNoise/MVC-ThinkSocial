<div class="w3-col m3 groups">
    <img src="/avatars/<?= $groupAvatar ?>" class="group-avatar-page-image" alt="Avatar">
    <a href="/groups/unsubscribe/id<?= $currentGroup->id?>" class="group-card__subs w3-btn w3-ripple w3-red group-card__subs-main"> Unsubscribe </a>
    <section class="group-page-subs">
        <h2 class="group-page-subs-title"> Subscribers </h2>
        <div class="subscriber-container subscriber-container-empty">
            Group has no subscribers
        </div>
    </section>
</div>