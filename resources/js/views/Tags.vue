<template>
    <div class="container">
        <div class="box filters d-flex justify-content-between">
            <h6 class="align-self-center my-0 mx-1"><tag-icon /> {{ $t('app.tags') }}</h6>
            <div>
                <input class="filter form-control" v-model="filters.q" :placeholder="$t('app.filters.search')">
                <div class="filter dropdown">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><sliders-icon /> {{
                        $t('app.filters.sort') }}</button>
                    <div class="dropdown-menu">
                        <template v-for="option in sorting">
                            <a class="dropdown-item"
                                @click="filters.order = (filters.sort == option && filters.order == 'desc' ? 'asc' : 'desc'); filters.sort = option"
                                :key="option">{{ $t('app.filters.' + option) }} <minus-icon
                                    v-if="filters.sort != option" /><arrow-down-icon
                                    v-else-if="filters.sort == option && filters.order == 'desc'" /><arrow-up-icon
                                    v-else /></a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3">
            <template v-if="status === 'loading'">
                <div class="d-flex flex-wrap">
                    <placeholder component="button" classes="m-1" v-for="i in new Array(10)" :key="i"
                        style="width: 100px; height: 38px;" />
                </div>
            </template>
            <div class="text-center py-5 w-100" v-else-if="status == 'error'">{{ $t('app.something_went_wrong') }}</div>
            <div v-else class="box p-3">
                <router-link v-for="(tag, index) in tags" :key="index" :to="{ name: 'tag', params: { slug: tag.slug } }"
                    class="btn btn-outline-primary m-1"
                    :style="{ borderColor: tag.color, color: tag.color ? tag.color : undefined }">
                    {{ tag.name }}
                    <span class="badge badge-light ml-1">{{ tag.comics_count }}</span>
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            tags: [],
            status: 'loading',
            sorting: [
                'name',
                'comics_count'
            ],
            filters: {
                q: this.$route.query.q ? this.$route.query.q : '',
                sort: this.$route.query.sort ? this.$route.query.sort : 'comics_count',
                order: this.$route.query.order ? this.$route.query.order : 'desc'
            }
        };
    },
    mounted() {
        this.get();
        this.$meta({
            title: this.$t('meta.title.tags'),
            description: this.$t('meta.description.tags')
        });
    },
    watch: {
        filters: {
            handler() {
                this.$router.replace({ query: { ...this.filters } });
                this.get();
            },
            deep: true
        }
    },
    methods: {
        get() {
            this.status = 'loading';
            // Request a large number of items to simulate "all" since backend now supports > 100
            let query = 'per_page=9999';
            this.$api.get('tags?' + query, { params: this.filters }).then(response => {
                let data = response.data;
                // Since we are using pagination structure in backend but requesting large page, 
                // data might be in data.data or directly data depending on how controller returns 'paginate' vs 'get'.
                // Controller returns 'paginate' so it will be in data.data
                this.tags = data.data;
                this.status = 'done';
            }).catch(error => {
                this.status = 'error';
            });
        }
    }
};
</script>
