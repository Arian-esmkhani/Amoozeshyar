import './bootstrap';
import Alpine from 'alpinejs'
import Focus from '@alpinejs/focus'
import Persist from '@alpinejs/persist'
import Livewire from '@livewire/alpine-plugin'

window.Alpine = Alpine

Alpine.plugin(Focus)
Alpine.plugin(Persist)
Alpine.plugin(Livewire)

Alpine.start()
