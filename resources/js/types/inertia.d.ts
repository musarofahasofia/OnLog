export {}

declare module '@inertiajs/vue3' {
  import { Page } from '@inertiajs/core'

  interface User {
    id: number
    name: string
    email: string
  }

  interface PageProps {
    auth?: {
      user?: User
    }
    flash?: {
      message?: string
      error?: string
    }
    [key: string]: any
  }

  export function usePage<TPageProps extends PageProps = PageProps>(): Page<TPageProps>
}
