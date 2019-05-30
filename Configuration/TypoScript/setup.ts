
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
}

plugin.tx_rkwfeecalculator._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-rkw-feecalculator table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-rkw-feecalculator table th {
        font-weight:bold;
    }

    .tx-rkw-feecalculator table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
