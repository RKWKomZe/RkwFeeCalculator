
plugin.tx_rkwfeecalculator_calculator {
  view {
    # cat=plugin.tx_rkwfeecalculator_calculator/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:rkw_feecalculator/Resources/Private/Templates/
    # cat=plugin.tx_rkwfeecalculator_calculator/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:rkw_feecalculator/Resources/Private/Partials/
    # cat=plugin.tx_rkwfeecalculator_calculator/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:rkw_feecalculator/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_rkwfeecalculator_calculator//a; type=string; label=Default storage PID
    storagePid =
  }
  settings {
    calculator = null,
    mandatoryFields {
      # cat=plugin.tx_rkwfeecalculator//f; type=string; label=mandatory fields for feecalculator
      calculation = selectedProgram,days,consultantFeePerDay
    }
  }
}
