@include('/layouts/components/header_button', ['buttonName' => 'New Request', 'buttonIcon' => "M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m-5-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2z"])
@includeIf('/layouts/dialog', ['dialog' => 'new_claim_request', 'dialogId' => 'mainAction'])
@includeIf('/layouts/dialog', ['dialog' => 'info', 'dialogId' => 'infoDialog'])