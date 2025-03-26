import './bootstrap';
import Alpine from 'alpinejs'
import Focus from '@alpinejs/focus'
import Persist from '@alpinejs/persist'

window.Alpine = Alpine

Alpine.plugin(Focus)
Alpine.plugin(Persist)

Alpine.start()
