import '@tabler/core/dist/js/autosize'
import '@tabler/core/src/js/src/dropdown'
import '@tabler/core/src/js/src/tooltip'
import '@tabler/core/src/js/src/popover'
import '@tabler/core/src/js/src/switch-icon'
import '@tabler/core/src/js/src/tab'
import * as bootstrap from 'bootstrap'
import * as tabler from '@tabler/core/src/js/src/tabler'

globalThis.bootstrap = bootstrap
globalThis.tabler = tabler

import setupProgress from './base/progress'

setupProgress({
    showSpinner: true,
})
