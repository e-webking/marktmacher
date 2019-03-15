
plugin.tx_armpackage {
    view {
        templateRootPaths.0 = EXT:armpackage/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_armpackage.view.templateRootPath}
        partialRootPaths.0 = EXT:armpackage/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_armpackage.view.partialRootPath}
        layoutRootPaths.0 = EXT:armpackage/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_armpackage.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_armpackage.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    settings {
        furnplanLoginUrl = {$plugin.tx_armpackage.settings.furnplanLoginUrl}
        furnplanRegUrl = {$plugin.tx_armpackage.settings.furnplanRegUrl}
        senderEmailAdresseFe = {$plugin.tx_armpackage.settings.senderEmailAdresseFe}
        senderName = {$plugin.tx_armpackage.settings.senderName}
    }
}

# these classes are only used in auto-generated templates
plugin.tx_armpackage._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-armpackage table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-armpackage table th {
        font-weight:bold;
    }

    .tx-armpackage table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
