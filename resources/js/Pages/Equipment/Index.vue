<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Equipment</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null" />
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo button-green" :href="route('equipment.create')">
                <span>Create</span>
                <span class="hidden md:inline">Equipment</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">City</th>
                    <th class="px-6 pt-6 pb-4 priority-low" colspan="2">Postal code</th>
                </tr>
                <tr v-for="eq in equipment.data" :key="eq.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('equipment.edit', eq.id)">
                            {{ eq.name }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('equipment.edit', eq.id)" tabindex="-1">
                            {{ eq.city }}
                        </inertia-link>
                    </td>
                    <td class="border-t priority-low">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('equipment.edit', eq.id)" tabindex="-1">
                            {{ eq.postal_code }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('equipment.edit', eq.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="equipment.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No equipment found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="equipment .links" />
    </div>
</template>

<script>
    import Icon from '@/Shared/Icon'
    import Layout from '@/Shared/Layout'
    import mapValues from 'lodash/mapValues'
    import Pagination from '@/Shared/Pagination'
    import pickBy from 'lodash/pickBy'
    import SearchFilter from '@/Shared/SearchFilter'
    import throttle from 'lodash/throttle'

    export default {
        metaInfo: { title: 'equipment' },
        layout: Layout,
        components: {
            Icon,
            Pagination,
            SearchFilter,
        },
        props: {
            equipment: Object,
            filters: Object,
        },
        data() {
            return {
                form: {
                    search: this.filters.search,
                    trashed: this.filters.trashed,
                },
            }
        },
        watch: {
            form: {
                handler: throttle(function() {
                    let query = pickBy(this.form)
                    this.$inertia.replace(this.route('equipment', Object.keys(query).length ? query : { remember: 'forget' }))
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = mapValues(this.form, () => null)
            },
        },
    }
</script>
