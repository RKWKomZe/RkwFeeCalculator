
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
    mandatoryFields {
      calculation = {$plugin.tx_rkwfeecalculator_calculator.settings.mandatoryFields.calculation}
    }
  }
}

plugin.rkwfeecalculator_calculator.settings < module.rkwfeecalculator_calculator.settings