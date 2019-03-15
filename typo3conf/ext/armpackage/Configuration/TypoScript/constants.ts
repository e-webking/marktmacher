
plugin.tx_armpackage {
    view {
        # cat=plugin.tx_armpackage_list/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:armpackage/Resources/Private/Templates/
        # cat=plugin.tx_armpackage_list/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:armpackage/Resources/Private/Partials/
        # cat=plugin.tx_armpackage_list/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:armpackage/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_armpackage_list//a; type=string; label=Default storage PID
        storagePid =
    }
    settings {
        furnplanLoginUrl = https://furnplan.academy/sign_in
        furnplanRegUrl = https://furnplan.academy/sign_up
        senderEmailAdresseFe = office@marktmacher.com
        senderName = Marcel Kuriger
    }
}
