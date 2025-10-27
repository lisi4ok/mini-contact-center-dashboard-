import { columns } from "./columns"
import { type Contact, type BreadcrumbItem } from "@/types"
import { DataTable } from "./data-table"
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { index, create } from '@/routes/contacts';
import { buttonVariants } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: index().url,
    },
];


export default function ContactIndex({ contacts }: { contacts: Contact[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Contacts" />
            <div className="container mx-auto py-10">
                <div className={'mt-8'}>
                    <Link className={buttonVariants({ variant: 'outline' })} href={create().url}>
                        Create Contact
                    </Link>
                </div>
                <DataTable columns={columns} data={contacts} />
            </div>
        </AppLayout>
    )
}
