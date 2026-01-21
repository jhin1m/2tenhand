<template>
    <div class="container">
        <div class="box filters d-flex justify-content-between">
            <h6 class="align-self-center my-0 mx-1"><image-icon /> {{ $t('app.artists') }}</h6>
            <div>
                <input class="filter form-control" v-model="filters.q" :placeholder="$t('app.filters.search')">
                <div class="filter dropdown">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><sliders-icon /> {{
                        $t('app.filters.sort') }}</button>
                    <div class="dropdown-menu">
                        <template v-for="option in sorting" :key="option">
                            <a class="dropdown-item"
                                @click="filters.order = (filters.sort == option && filters.order == 'desc' ? 'asc' : 'desc'); filters.sort = option">{{
                                    $t('app.filters.' + option) }} <minus-icon
                                    v-if="filters.sort != option" /><arrow-down-icon
                                    v-else-if="filters.sort == option && filters.order == 'desc'" /><arrow-up-icon
                                    v-else /></a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <card-grid :items="artists" :status="status" component-type="artist" layout="large" :placeholder-count="18" />
        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="12" @paginate="paginate">
        </pagination>
    </div>
</template>
<script>
import CardGrid from '../components/CardGrid';

export default {
    components: {
        CardGrid
    },
    data() {
        return {
            artists: [],
            pagination: {
                current_page: this.$route.query.page ? this.$route.query.page : 1
            },
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
            title: this.$t('meta.title.artists'),
            description: this.$t('meta.description.default')
        });
    },
    watch: {
        filters: {
            handler() {
                this.$router.replace({ query: { page: this.pagination.current_page, ...this.filters } });
                this.get();
            },
            deep: true
        }
    },
    methods: {
        get() {
            this.status = 'loading';
            this.$api.get('artists?page=' + this.pagination.current_page, { params: this.filters }).then(response => {
                let data = response.data;
                this.artists = data.data;
                this.pagination = {
                    total: data.total,
                    per_page: data.per_page,
                    current_page: data.current_page,
                    last_page: data.last_page,
                    from: data.to,
                    to: data.to,
                };
                this.status = 'done';
            }).catch(error => {
                this.status = 'error';
            });
        },
        paginate() {
            this.$router.replace({ query: { page: this.pagination.current_page } });
            this.get();
        }
    }
};
</script>
