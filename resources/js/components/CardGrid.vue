<template>
    <div class="row mt-3 mb-2">
        <!-- Loading State -->
        <template v-if="status === 'loading'">
            <placeholder :component="computedPlaceholderType" :classes="gridClass" v-for="i in placeholderCount"
                :key="i" />
        </template>

        <!-- Error State -->
        <div class="text-center py-5 w-100" v-else-if="status === 'error'">
            {{ $t('app.something_went_wrong') }}
        </div>

        <!-- Data Display -->
        <template v-else-if="items.length">
            <div v-for="(item, index) in items" :key="item.id || index" :class="gridClass">
                <component :is="componentType" :[computedComponentProp]="item" />
            </div>
        </template>

        <!-- Empty State -->
        <slot name="empty" v-else>
            <div class="my-5 py-5 text-center w-100">
                {{ $t('app.no_results') }}
            </div>
        </slot>
    </div>
</template>

<script>
import Comic from './content/Comic';
import Artist from './content/Artist';
import Author from './content/Author';
import Character from './content/Character';
import Tag from './content/Tag';
import Group from './content/Group';
import Parody from './content/Parody';

export default {
    name: 'CardGrid',
    components: {
        Comic,
        Artist,
        Author,
        Character,
        Tag,
        Group,
        Parody
    },
    props: {
        // Array of items to display
        items: {
            type: Array,
            default: () => []
        },
        // Loading status: 'loading', 'done', 'error'
        status: {
            type: String,
            default: 'loading'
        },
        // Component to render for each item (e.g., 'comic', 'artist', 'author')
        componentType: {
            type: String,
            required: true
        },
        // Prop name to pass to the component (e.g., 'comic', 'artist', 'author')
        componentProp: {
            type: String,
            default: null
        },
        // Grid layout: 'large' (6 cols) or 'default' (4 cols)
        layout: {
            type: String,
            default: 'default',
            validator: (value) => ['default', 'large'].includes(value)
        },
        // Custom grid class (overrides layout prop if provided)
        customGridClass: {
            type: String,
            default: null
        },
        // Placeholder type for loading state
        placeholderType: {
            type: String,
            default: null
        },
        // Number of placeholder items to show during loading
        placeholderCount: {
            type: Number,
            default: 18
        }
    },
    computed: {
        gridClass() {
            if (this.customGridClass) {
                return this.customGridClass;
            }
            // Default: 4 columns on desktop (col-lg-3)
            // Large: 6 columns on desktop (col-lg-2)
            return this.layout === 'large'
                ? 'col-6 col-sm-4 col-md-3 col-lg-2 p-3'
                : 'col-6 col-sm-4 col-md-4 col-lg-3 p-3';
        },
        computedPlaceholderType() {
            return this.placeholderType || this.componentType;
        },
        computedComponentProp() {
            return this.componentProp || this.componentType;
        }
    }
};
</script>
