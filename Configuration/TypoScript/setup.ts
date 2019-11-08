
plugin.tx_rkwfeecalculator_calculator {
  view {
    templateRootPaths.0 = EXT:rkw_feecalculator/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_rkwfeecalculator_calculator.view.templateRootPath}
    partialRootPaths.0 = EXT:rkw_feecalculator/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_rkwfeecalculator_calculator.view.partialRootPath}
    layoutRootPaths.0 = EXT:rkw_feecalculator/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_rkwfeecalculator_calculator.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_rkwfeecalculator_calculator.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
  settings {
    calculator = {$plugin.tx_rkwfeecalculator_calculator.settings.calculator}

  }
}

plugin.rkwfeecalculator_calculator.settings < module.rkwfeecalculator_calculator.settings

plugin.tx_rkwfeecalculator_request {
    view {
        templateRootPaths.0 = EXT:rkw_feecalculator/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_rkwfeecalculator_request.view.templateRootPath}
        partialRootPaths.0 = EXT:rkw_feecalculator/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_rkwfeecalculator_request.view.partialRootPath}
        layoutRootPaths.0 = EXT:rkw_feecalculator/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_rkwfeecalculator_request.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_rkwfeecalculator_request.persistence.storagePid}
        #recursive = 1
        classes {
            RKW\RkwFeecalculator\Domain\Model\BackendUser {
                mapping {
                    tableName = be_users
                }
            }
        }
    }
    features {
        #skipDefaultArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
    settings {
        termsPid = {$plugin.tx_rkwfeecalculator_request.settings.termsPid}
        terms2Pid = {$plugin.tx_rkwfeecalculator_request.settings.terms2Pid}
        storagePid = {$plugin.tx_rkwfeecalculator_request.persistence.storagePid}
        programStoragePid = {$plugin.tx_rkwfeecalculator_calculator.persistence.storagePid}
        includeRkwRegistrationPrivacy = {$plugin.tx_rkwfeecalculator_request.settings.includeRkwRegistrationPrivacy}
    }
}

plugin.tk_rkwfeecalculator_request < plugin.tx_rkwfeecalculator_request

page.includeCSS.txRkwFeecalculator = EXT:rkw_feecalculator/Resources/Public/Css/Feecalculator.css
