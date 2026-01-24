<template>
    <div class="container comic-page">
        <div class="row mb-4" v-if="status.comic == 'loading'">
            <div class="col-12 text-center py-5">
                <div class="spinner-border my-5"></div>
            </div>
        </div>
        <div class="row mb-4" v-else-if="status.comic == 'error'">
            <div class="col-12 text-center py-5 box">
                {{ $t('app.something_went_wrong') }}
            </div>
        </div>
        <template v-else>
            <!-- Header Section: Cover + Info -->
            <div class="box mb-4 p-3">
                <div class="row">
                    <!-- Left Column: Cover Image -->
                    <div class="col-12 col-md-4 col-lg-3 text-center text-md-left">
                        <div class="comic-image mb-3">
                            <router-link
                                :to="{ name: 'comic/reader', params: { slug: comic.slug, chapter: comic.first_chapter ? comic.first_chapter.slug : undefined } }">
                                <img class="w-100 rounded shadow-sm" :src="comic.image_url"
                                    :alt="`${comic.title} cover`" />
                            </router-link>
                        </div>
                    </div>

                    <!-- Right Column: Info & Metadata -->
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="comic-info">
                            <h1 class="comic-title font-weight-bold mb-1">{{ comic.title }}</h1>
                            <h4 class="comic-alternative-title text-muted mb-3" v-if="comic.alternative_title">{{
                                comic.alternative_title }}</h4>

                            <!-- Metadata List -->
                            <div class="metadata-list">
                                <!-- Parodies -->
                                <div class="tag-container mb-2" v-if="comic.parodies && comic.parodies.length">
                                    <span class="text-muted mr-2">{{ $t('app.comic.parodies') }}:</span>
                                    <span class="tags">
                                        <router-link v-for="(parody, key) in comic.parodies" :key="'parody-' + key"
                                            :to="{ name: 'parody', params: { slug: parody.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ parody.name }}
                                            <span class="badge badge-light ml-1" v-if="parody.comics_count">{{
                                                parody.comics_count }}</span>
                                        </router-link>
                                    </span>
                                </div>

                                <!-- Characters -->
                                <div class="tag-container mb-2" v-if="comic.characters && comic.characters.length">
                                    <span class="text-muted mr-2">{{ $t('app.comic.characters') }}:</span>
                                    <span class="tags">
                                        <router-link v-for="(character, key) in comic.characters"
                                            :key="'character-' + key"
                                            :to="{ name: 'character', params: { slug: character.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ character.name }}
                                            <span class="badge badge-light ml-1" v-if="character.comics_count">{{
                                                character.comics_count }}</span>
                                        </router-link>
                                    </span>
                                </div>

                                <!-- Tags -->
                                <div class="tag-container mb-2" v-if="comic.tags && comic.tags.length">
                                    <span class="text-muted mr-2">{{ $t('app.comic.tags') }}:</span>
                                    <span class="tags">
                                        <router-link v-for="(tag, key) in comic.tags" :key="'tag-' + key"
                                            :to="{ name: 'tag', params: { slug: tag.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ tag.name }}
                                            <span class="badge badge-light ml-1" v-if="tag.comics_count">{{
                                                tag.comics_count
                                                }}</span>
                                        </router-link>
                                    </span>
                                </div>

                                <!-- Artists -->
                                <div class="tag-container mb-2" v-if="comic.artists && comic.artists.length">
                                    <span class="text-muted mr-2">{{ $t('app.comic.artists') }}:</span>
                                    <span class="tags">
                                        <router-link v-for="(artist, key) in comic.artists" :key="'artist-' + key"
                                            :to="{ name: 'artist', params: { slug: artist.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ artist.name }}
                                            <span class="badge badge-light ml-1" v-if="artist.comics_count">{{
                                                artist.comics_count }}</span>
                                        </router-link>
                                    </span>
                                </div>

                                <!-- Groups -->
                                <div class="tag-container mb-2" v-if="comic.groups && comic.groups.length">
                                    <span class="text-muted mr-2">{{ $t('app.comic.groups') }}:</span>
                                    <span class="tags">
                                        <router-link v-for="(group, key) in comic.groups" :key="'group-' + key"
                                            :to="{ name: 'group', params: { slug: group.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ group.name }}
                                            <span class="badge badge-light ml-1" v-if="group.comics_count">{{
                                                group.comics_count }}</span>
                                        </router-link>
                                    </span>
                                </div>

                                <!-- Languages -->
                                <div class="tag-container mb-2" v-if="comic.language">
                                    <span class="text-muted mr-2">{{ $t('app.comic.language') }}:</span>
                                    <span class="tags">
                                        <router-link :to="{ name: 'language', params: { slug: comic.language.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ comic.language.name }}
                                        </router-link>
                                        <span v-if="comic.translated" class="badge badge-secondary mr-1 mb-1 p-2">{{
                                            $t('app.attributes.translated') }}</span>
                                        <span v-if="comic.rewritten" class="badge badge-secondary mr-1 mb-1 p-2">{{
                                            $t('app.attributes.rewritten') }}</span>
                                        <span v-if="comic.speechless" class="badge badge-secondary mr-1 mb-1 p-2">{{
                                            $t('app.attributes.speechless') }}</span>
                                    </span>
                                </div>

                                <!-- Categories -->
                                <div class="tag-container mb-2" v-if="comic.category">
                                    <span class="text-muted mr-2">{{ $t('app.comic.category') }}:</span>
                                    <span class="tags">
                                        <router-link :to="{ name: 'category', params: { slug: comic.category.slug } }"
                                            class="badge badge-secondary mr-1 mb-1 p-2">
                                            {{ comic.category.name }}
                                        </router-link>
                                    </span>
                                </div>

                                <!-- Pages -->
                                <div class="tag-container mb-2">
                                    <span class="text-muted mr-2">{{ $t('app.comic.pages') }}:</span>
                                    <span class="tags">
                                        <span class="badge badge-secondary mr-1 mb-1 p-2">{{ comic.pages }}</span>
                                    </span>
                                </div>

                                <!-- Uploaded At -->
                                <div class="tag-container mb-2">
                                    <span class="text-muted mr-2">{{ $t('app.comic.uploaded_at') }}:</span>
                                    <span class="tags">
                                        <span class="badge badge-secondary mr-1 mb-1 p-2">{{ comic.uploaded_at }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="comic-actions mt-4">
                                <button class="btn btn-danger mr-2"
                                    @click="isLoggedIn ? favorite() : $root.$emit('open-modal', 'Login')">
                                    <heart-icon :style="{ fill: comic.favorited ? 'white' : 'none' }" />
                                    {{ comic.favorited ? $t('app.comic.favorited') : $t('app.comic.favorite') }}
                                    <span class="badge badge-light ml-1 text-dark">{{ comic.favorites }}</span>
                                </button>

                                <router-link v-if="comic.downloadable"
                                    :to="{ name: 'comic/download', params: { slug: comic.slug } }"
                                    class="btn btn-secondary" :event="isLoggedIn ? 'click' : ''"
                                    @click.native.prevent="isLoggedIn ? null : $root.$emit('open-modal', 'Login') && $ga.event('comics', 'guest-download')">
                                    <download-icon /> {{ $t('app.comic.download') }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description (Optional) -->
            <div class="row mb-4" v-if="comic.description">
                <div class="col-12">
                    <div class="box p-3">
                        <h6 class="box-header mb-2">{{ $t('app.comic.description') }}</h6>
                        <p>{{ comic.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Download Section Logic (Preserved) -->
            <template v-if="section == 'download'">
                <div id="download" class="box mb-4">
                    <h6 class="box-header mb-2">
                        <download-icon /> {{ $t('app.comic.download_title') }}
                    </h6>
                    <div class="comic-download col-md-8 text-center mx-auto py-5">
                        <p>{{ $t('app.comic.download_text') }}</p>
                        <div class="progress mb-4" v-show="download.progress">
                            <div class="progress-bar"
                                :class="{ 'bg-success': download.progress == 100, 'bg-danger': download.failed }"
                                :style="{ width: download.progress + '%' }"></div>
                        </div>
                        <button class="btn btn-primary mx-auto px-4" @click="initDownload()"
                            :disabled="download.disabled"><download-icon /> {{ $t('app.comic.download')
                            }}</button>
                    </div>
                </div>
            </template>

            <!-- Gallery/Chapters/Comments -->
            <div class="row">
                <div class="col-12">
                    <div v-if="$app.is_mobile || true">
                        <!-- forcing layout for desktop too as nHentai is full width gallery -->
                        <div v-if="canRead && status.chapters === 'loading' && status.images === 'loading'"
                            class="box mb-4 text-center py-5 w-100">
                            <div class="spinner-border"></div>
                        </div>
                        <comic-premium v-else-if="!canRead" />
                        <!-- Chapters List -->
                        <comic-chapters v-else-if="comic.chapters_count" :comic="comic" :chapters="chapters" />
                        <!-- Gallery Grid -->
                        <comic-gallery v-if="status.images === 'done'" :comic="comic" :images="images" />
                    </div>

                    <recommendations-wrapper type="comic" :entry="comic.id" class="mt-4"></recommendations-wrapper>
                    <comments-wrapper type="comic" :entry="comic.id" :parent_id="$route.params.identifier"
                        class="mt-4" />
                </div>
            </div>
        </template>
    </div>
</template>
<script>
import Glide from '@glidejs/glide';
import RecommendationsWrapper from '../components/RecommendationsWrapper';
import CommentsWrapper from '../components/comments/Wrapper';
import Character from '../components/content/Character';
import Comic from '../components/content/Comic';
import AdSpot from '../components/AdSpot';
import { mapGetters } from 'vuex';

const ComicPremium = {
    data: () => ({
        component: {
            template: '<div class="text-center"><div class="spinner-border my-5 mx-auto"></div></div>'
        }
    }),
    mounted() {
        this.component = () => ({
            component: import(/* webpackMode: "lazy", webpackChunkName: "auth.bundle" */ `../components/auth/Register`),
            loading: {
                template: '<div class="text-center"><div class="spinner-border my-5 mx-auto"></div></div>'
            },
            error: {
                template: '<div class="text-center my-5">{{ $t("app.something_went_wrong") }}</div>'
            },
            delay: 200,
            timeout: 5000
        })
    },
    template: `<transition name="fade" mode="out-in">
            <component :subtitle="$t('app.comic.premium')" :modal="true" class="col-md-6 p-0 mb-4 mx-auto" :is="component" v-if="component"><span class="icon-wrapper icon-wrapper-premium"><lock-icon/></span></component>
        </transition>`
};

const ComicGallery = {
    data: () => ({
        collapsed: true,
    }),
    props: ['comic', 'images'],
    mounted() {
        if (this.images.length <= 12) this.collapsed = false;
    },
    watch: {
        images(newImages) {
            if (newImages.length <= 12) this.collapsed = false;
        }
    },
    template: `<div class="box mb-4">
            <h6 class="box-header mb-2">
                <list-icon/> {{ $t('app.comic.gallery') }} ({{ comic.pages }})
            </h6>
            <div class="comic-gallery d-flex flex-wrap" :class="{collapsed}">
                <div v-for="(image, key) in images" :key="key" class="gallery-image col-6 col-md-3 py-3">
                    <router-link :to="{ name: 'comic/reader', params: { slug: comic.slug, page: image.page } }"><img class="w-100 rounded-sm" v-lazy="image.thumbnail_url" :alt="\`\${comic.title} thumbnail page \${image.page}\`" referrerpolicy="no-referrer"></router-link>
                </div>
                <div v-if="collapsed" class="box-actions d-flex align-items-center justify-content-center">
                    <button class="btn btn-secondary mx-2" @click="collapsed = false"><arrow-down-icon/> {{ $t('app.comic.load_more') }}</button>
                    <router-link :to="{ name: 'comic/reader', params: { slug: comic.slug } }"  class="btn btn-primary mx-2"><book-open-icon/> {{ $t('app.comic.read') }}</router-link>
                </div>
            </div>
        </div>`
};

const ComicChapters = {
    data: () => ({
        collapsed: true,
    }),
    props: ['comic', 'chapters'],
    mounted() {
        if (this.chapters.length <= 12) this.collapsed = false;
    },
    template: `<div class="box mb-4">
            <h6 class="box-header mb-2">
                <list-icon/> {{ $t('app.comic.chapters') }} ({{ comic.chapters_count }})
                <router-link :to="{ name: 'comic/reader', params: { slug: comic.slug, chapter: comic.first_chapter.slug } }" class="btn btn-outline-light py-0 ml-3">{{ $t('app.comic.read_first') }}</router-link>
            </h6>
            <div class="comic-chapters" :class="{collapsed}">
                <router-link v-for="(chapter, key) in chapters" :key="key" :to="{ name: 'comic/reader', params: { slug: comic.slug, chapter: chapter.slug } }" class="comic-chapter py-2" :class="{ 'read': chapter.read }">{{ chapter.name }}<span class="chapter-date float-right text-muted">{{ chapter.added_at }}</span></router-link>
                <div v-if="collapsed" class="box-actions d-flex align-items-center justify-content-center">
                    <button class="btn btn-secondary mx-2" @click="collapsed = false"><arrow-down-icon/> {{ $t('app.comic.load_more') }}</button>
                    <router-link :to="{ name: 'comic/reader', params: { slug: comic.slug, chapter: comic.first_chapter.slug } }" class="btn btn-primary mx-2"><book-open-icon/> {{ $t('app.comic.read') }}</router-link>
                </div>
            </div>
        </div>`
};

export default {
    components: {
        'comic-premium': ComicPremium,
        'comic-gallery': ComicGallery,
        'comic-chapters': ComicChapters,
        RecommendationsWrapper,
        CommentsWrapper,
        Character,
        AdSpot,
        Comic
    },
    data() {
        return {
            expanded: false,
            alert: {
                show: false,
                type: "danger",
                content: "",
            },
            comic: {},
            chapters: [],
            images: [],
            status: {
                comic: 'loading',
                images: 'loading',
                chapters: 'loading'
            },
            section: 'main',
            download: {
                disabled: false,
                failed: false,
                progress: null
            }
        };
    },
    mounted() {
        this.fill();
    },
    updated() {
        this.$meta({
            title: this.$t('meta.title.comic', { title: this.comic.title }),
            description: this.comic.meta_description
        });
        this.updateSection();
    },
    computed: {
        ...mapGetters(["isLoggedIn"]),
        canRead() {
            return !this.comic.premium || this.isLoggedIn;
        }
    },
    watch: {
        '$route'(to, from) {
            if (to.params.slug !== from.params.slug) {
                this.fill();
            }
            this.updateSection();
        },
        isLoggedIn() {
            this.fill();
        }
    },
    methods: {
        updateSection() {
            if (this.$route.name === 'comic/characters') this.section = 'characters';
            else if (this.$route.name === 'comic/comments') this.section = 'comments';
            else if (this.$route.name === 'comic/download' && this.comic.downloadable) {
                this.section = 'download';
                this.$nextTick(() => {
                    document.querySelector('#download').scrollIntoView({ behavior: 'smooth' });
                });
            }
            else this.section = 'main';
        },
        fill() {
            let slug = this.$route.params.slug;
            this.status.comic = 'loading';
            this.status.chapters = 'loading';
            this.status.images = 'loading';
            this.$api.get(['comics', slug].join('/')).then(response => {
                this.comic = response.data;
                this.status.comic = 'done';
                this.$root.$emit('header-data', {
                    ...this.comic
                });
                if (!this.canRead) return;
                if (this.comic.chapters_count) this.$api.get(['comics', slug, 'chapters'].join('/'))
                    .then(response => {
                        this.chapters = response.data;
                        this.status.chapters = 'done';
                    })
                    .catch(error => this.status.chapters = 'error');
                else this.$api.get(['comics', slug, 'images'].join('/'))
                    .then(response => {
                        this.images = response.data.images;
                        this.status.images = 'done';
                    })
                    .catch(error => this.status.images = 'error');
            }).catch(error => {
                if (error.response.status == 404) {
                    this.$router.replace('/404')
                }
                this.status.comic = 'error';
            });
        },
        favorite() {
            this.$api.post(['comics', this.comic.slug, 'favorite'].join('/')).then(response => {
                this.comic.favorited = response.data.favorited;
                this.comic.favorites = response.data.favorites;
                this.$ga.event('comics', response.data.favorited ? 'favorited' : 'unfavorited');
            });
        },
        initDownload() {
            this.download.disabled = true;
            this.download.failed = false;
            this.$api.get(['comics', this.comic.slug, 'download'].join('/')).then(response => {
                this.$api.get(response.data.download_url, {
                    responseType: 'blob',
                    onDownloadProgress: (progressEvent) => {
                        this.download.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    },
                    transformRequest: [(data, headers) => {
                        delete headers.common['X-Requested-With'];
                        delete headers.common['X-CSRF-TOKEN'];
                        delete headers.common['Authorization'];
                        return data;
                    }]
                }).then(({ data }) => {
                    const downloadUrl = window.URL.createObjectURL(new Blob([data]));
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.setAttribute('download', this.comic.title + '.zip');
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    this.$ga.event('comics', 'downloaded');
                }).catch(() => {
                    this.download.failed = true;
                }).finally(() => {
                    this.download.disabled = false;
                });
            }).catch((e) => {
                this.download.failed = true;
                this.download.disabled = false;
            });
        }
    }
};
</script>
