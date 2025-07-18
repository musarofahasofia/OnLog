// types/index.d.ts
export interface User {
  id: number
  name: string
  email: string
  photo?: string
  // ... tambahkan jika ada field lain
}

export interface SharedData {
  auth: {
    user: User
  }
  flash?: {
    message?: string
  }
}
