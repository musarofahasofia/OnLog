<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { Primitive, type PrimitiveProps } from 'reka-ui'
import { type ButtonVariants, buttonVariants } from '.'
import { Spinner } from '@/components/ui/spinner'

interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant']
    size?: ButtonVariants['size']
    class?: HTMLAttributes['class']
    loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    as: 'button',
    loading: false,
})
</script>

<template>
    <Primitive data-slot="button" :as="as" :as-child="asChild" :disabled="props.loading"
        :class="cn(buttonVariants({ variant, size }), props.class)">
        <span v-if="props.loading" class="inline-flex">
            <Spinner class="animate-spin h-4 w-4" />
        </span>
        <slot />
    </Primitive>
</template>
