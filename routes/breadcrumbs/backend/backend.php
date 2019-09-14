<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});
Breadcrumbs::register('admin.transactions', function ($breadcrumbs) {
    $breadcrumbs->push(__('Transactions'), route('admin.transactions'));
});
Breadcrumbs::register('admin.transactions.info', function ($breadcrumbs) {
    $breadcrumbs->push(__('Transaction Info'), route('admin.transactions.info', 0));
});
Breadcrumbs::register('admin.support', function ($breadcrumbs) {
    $breadcrumbs->push(__('Support'), route('admin.support'));
});
Breadcrumbs::register('admin.withdraw', function ($breadcrumbs) {
    $breadcrumbs->push(__('Withdraw'), route('admin.withdraw'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
