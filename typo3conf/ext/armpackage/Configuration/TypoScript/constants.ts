
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
        senderEmailAdresse = office@marktmacher.com
        senderName = Marcel Kuriger
        paymentUid = 23
        currency = EUR
        subject = Kursanmeldung unter www.marktmacher.com
        bankdata = Raiffeisenbank  Hauptstrasse 19   8840 Einsiedeln   SWIFT-BIC: RAIFCH22   Cl No. 81361 IBAN: CH88 8080 8006 6519 4375 5
    }
}
