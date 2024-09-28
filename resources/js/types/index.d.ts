export interface User {
    id: number;
    name: string;
    email: string;
    phone_no: string;
    email_verified_at?: string;
    station_id: number
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
