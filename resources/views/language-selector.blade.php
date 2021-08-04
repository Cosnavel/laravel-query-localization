<div class="{{$this->merge('max-w-2xs', $class)}}">
    <div x-data="Components.listbox({ modelName: 'selected', open: false, selectedIndex: @entangle('activeLanguage'), activeIndex: 0, items: @entangle('languages') })"
        x-init="init()">

        <div class="relative">
            <button type="button"
                class="relative w-full bg-white border border-gray-300 rounded shadow-sm pl-2 pr-7 py-1 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-sm"
                x-ref="button" @keydown.arrow-up.stop.prevent="onButtonClick()"
                @keydown.arrow-down.stop.prevent="onButtonClick()" @click="onButtonClick()" aria-haspopup="listbox"
                :aria-expanded="open" aria-labelledby="{{__('Choose language')}}">
                <div class="flex items-center">
                    <span>
                        <x-fas-globe class="h-4 w-4" /></span>
                    {{-- Uncomment if you want to display a flag in the language selector --}}
                    {{-- <span x-text="selected.flag"></span> --}}
                    <span x-text="selected.name" class="ml-2 truncate hidden xs:block"></span>
                </div>
                <span class="absolute inset-y-0 right-0 flex items-center pr-1 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" x-description="Heroicon name: solid/selector"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
            </button>


            <ul x-show="open" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                {{-- Class bottom-10 to have th menu to the upside --}}
                class="absolute right-0 xs:right-auto xs:left-0 w-min max-h-60 mt-1 mb-2 py-1 bg-white shadow-lg rounded-md text-base ring-1 ring-black ring-opacity-5 overflow-y-auto overflow-x-hidden focus:outline-none sm:text-sm"
                x-max="1" @click.away="open = false" x-description="Select popover, show/hide based on select state."
                @keydown.enter.stop.prevent="onOptionSelect()" @keydown.space.stop.prevent="onOptionSelect()"
                @keydown.escape="onEscape()" @keydown.arrow-up.prevent="onArrowUp()"
                @keydown.arrow-down.prevent="onArrowDown()" x-ref="listbox" tabindex="-1" role="listbox"
                aria-label="{{__('Choose language')}}" :aria-activedescendant="activeDescendant" style="display: none;">

                @foreach ($languages as $key => $language )
                <li x-state:on="Highlighted" x-state:off="Not Highlighted"
                    class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    id="listbox-option-{{$key}}" role="option" @click="choose({{$key}})"
                    @mouseenter="activeIndex = {{$key}}" @mouseleave="activeIndex = null"
                    :class="{ 'text-white bg-primary': activeIndex === {{$key}}, 'text-gray-900': !(activeIndex === {{$key}}) }">
                    <div class="flex items-center">
                        {{-- Uncomment if you want to display a flag in the language selector --}}
                        {{-- {{$language['flag']}} --}}
                        <span x-state:on="Selected" x-state:off="Not Selected" class="font-normal ml-2 block truncate"
                            :class="{ 'font-semibold': selectedIndex === {{$key}}, 'font-normal': !(selectedIndex === {{$key}}) }">
                            {{$language['name']}}
                        </span>
                    </div>

                    <span x-description="Checkmark, only display for selected option." x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        class="text-primary absolute inset-y-0 right-0 flex items-center pr-4"
                        :class="{ 'text-white': activeIndex === {{$key}}, 'text-primary': !(activeIndex === {{$key}}) }"
                        x-show="selectedIndex === {{$key}}" style="display: none;">
                        <svg class="h-5 w-5" x-description="Heroicon name: solid/check"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </li>
                @endforeach

            </ul>

        </div>
    </div>

</div>
<script>
    ;(window.Components = {}),
    (window.Components.listbox = function (t) {
        return {
            init() {
                ;(this.optionCount = this.$refs.listbox.children.length),
                    this.$watch('activeIndex', t => {
                        this.open &&
                            (null !== this.activeIndex
                                ? (this.activeDescendant = this.$refs.listbox.children[
                                      this.activeIndex
                                  ].id)
                                : (this.activeDescendant = ''))
                    })
            },
            activeDescendant: null,
            optionCount: null,
            open: !1,
            activeIndex: null,
            selectedIndex: 0,
            get active() {
                return this.items[this.activeIndex]
            },
            get [t.modelName || 'selected']() {
                return this.items[this.selectedIndex]
            },
            choose(t) {
                ;(this.selectedIndex = t), (this.open = !1)
            },
            onButtonClick() {
                this.open ||
                    ((this.activeIndex = this.selectedIndex),
                    (this.open = !0),
                    this.$nextTick(() => {
                        this.$refs.listbox.focus(),
                            this.$refs.listbox.children[
                                this.activeIndex
                            ].scrollIntoView({ block: 'nearest' })
                    }))
            },
            onOptionSelect() {
                null !== this.activeIndex &&
                    (this.selectedIndex = this.activeIndex),
                    (this.open = !1),
                    this.$refs.button.focus()
            },
            onEscape() {
                ;(this.open = !1), this.$refs.button.focus()
            },
            onArrowUp() {
                ;(this.activeIndex =
                    this.activeIndex - 1 < 0
                        ? this.optionCount - 1
                        : this.activeIndex - 1),
                    this.$refs.listbox.children[
                        this.activeIndex
                    ].scrollIntoView({ block: 'nearest' })
            },
            onArrowDown() {
                ;(this.activeIndex =
                    this.activeIndex + 1 > this.optionCount - 1
                        ? 0
                        : this.activeIndex + 1),
                    this.$refs.listbox.children[
                        this.activeIndex
                    ].scrollIntoView({ block: 'nearest' })
            },
            ...t,
        }
    }),
    (window.Components.menu = function (t = { open: !1 }) {
        return {
            init() {
                ;(this.items = Array.from(
                    this.$el.querySelectorAll('[role="menuitem"]'),
                )),
                    this.$watch('open', () => {
                        this.open && (this.activeIndex = -1)
                    })
            },
            activeDescendant: null,
            activeIndex: null,
            items: null,
            open: t.open,
            focusButton() {
                this.$refs.button.focus()
            },
            onButtonClick() {
                ;(this.open = !this.open),
                    this.open &&
                        this.$nextTick(() => {
                            this.$refs['menu-items'].focus()
                        })
            },
            onButtonEnter() {
                ;(this.open = !this.open),
                    this.open &&
                        ((this.activeIndex = 0),
                        (this.activeDescendant = this.items[
                            this.activeIndex
                        ].id),
                        this.$nextTick(() => {
                            this.$refs['menu-items'].focus()
                        }))
            },
            onArrowUp() {
                if (!this.open)
                    return (
                        (this.open = !0),
                        (this.activeIndex = this.items.length - 1),
                        void (this.activeDescendant = this.items[
                            this.activeIndex
                        ].id)
                    )
                0 !== this.activeIndex &&
                    ((this.activeIndex =
                        -1 === this.activeIndex
                            ? this.items.length - 1
                            : this.activeIndex - 1),
                    (this.activeDescendant = this.items[this.activeIndex].id))
            },
            onArrowDown() {
                if (!this.open)
                    return (
                        (this.open = !0),
                        (this.activeIndex = 0),
                        void (this.activeDescendant = this.items[
                            this.activeIndex
                        ].id)
                    )
                this.activeIndex !== this.items.length - 1 &&
                    ((this.activeIndex = this.activeIndex + 1),
                    (this.activeDescendant = this.items[this.activeIndex].id))
            },
            onClickAway(t) {
                if (this.open) {
                    const e = [
                        '[contentEditable=true]',
                        '[tabindex]',
                        'a[href]',
                        'area[href]',
                        'button:not([disabled])',
                        'iframe',
                        'input:not([disabled])',
                        'select:not([disabled])',
                        'textarea:not([disabled])',
                    ]
                        .map(t => `${t}:not([tabindex='-1'])`)
                        .join(',')
                    ;(this.open = !1), t.target.closest(e) || this.focusButton()
                }
            },
        }
    }),
    (window.Components.popoverGroup = function () {
        return {
            __type: 'popoverGroup',
            init() {
                let t = e => {
                    document.body.contains(this.$el)
                        ? e.target instanceof Element &&
                          !this.$el.contains(e.target) &&
                          window.dispatchEvent(
                              new CustomEvent('close-popover-group', {
                                  detail: this.$el,
                              }),
                          )
                        : window.removeEventListener('focus', t, !0)
                }
                window.addEventListener('focus', t, !0)
            },
        }
    }),
    (window.Components.popover = function ({
        open: t = !1,
        focus: e = !1,
    } = {}) {
        const i = [
            '[contentEditable=true]',
            '[tabindex]',
            'a[href]',
            'area[href]',
            'button:not([disabled])',
            'iframe',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
        ]
            .map(t => `${t}:not([tabindex='-1'])`)
            .join(',')
        return {
            __type: 'popover',
            open: t,
            init() {
                e &&
                    this.$watch('open', t => {
                        t &&
                            this.$nextTick(() => {
                                !(function (t) {
                                    const e = Array.from(t.querySelectorAll(i))
                                    !(function t(i) {
                                        void 0 !== i &&
                                            (i.focus({ preventScroll: !0 }),
                                            document.activeElement !== i &&
                                                t(e[e.indexOf(i) + 1]))
                                    })(e[0])
                                })(this.$refs.panel)
                            })
                    })
                let t = i => {
                    if (!document.body.contains(this.$el))
                        return void window.removeEventListener('focus', t, !0)
                    let n = e ? this.$refs.panel : this.$el
                    if (
                        this.open &&
                        i.target instanceof Element &&
                        !n.contains(i.target)
                    ) {
                        let t = this.$el
                        for (; t.parentNode; )
                            if (
                                ((t = t.parentNode),
                                t.__x instanceof this.constructor)
                            ) {
                                if ('popoverGroup' === t.__x.$data.__type)
                                    return
                                if ('popover' === t.__x.$data.__type) break
                            }
                        this.open = !1
                    }
                }
                window.addEventListener('focus', t, !0)
            },
            onEscape() {
                ;(this.open = !1), this.restoreEl && this.restoreEl.focus()
            },
            onClosePopoverGroup(t) {
                t.detail.contains(this.$el) && (this.open = !1)
            },
            toggle(t) {
                ;(this.open = !this.open),
                    this.open
                        ? (this.restoreEl = t.currentTarget)
                        : this.restoreEl && this.restoreEl.focus()
            },
        }
    }),
    (window.Components.radioGroup = function ({
        initialCheckedIndex: t = 0,
    } = {}) {
        return {
            value: void 0,
            init() {
                this.value = Array.from(this.$el.querySelectorAll('input'))[
                    t
                ]?.value
            },
        }
    })

</script>
