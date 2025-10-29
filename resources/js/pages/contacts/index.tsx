import { columns } from "./columns"
import { type Contact, type BreadcrumbItem, type SharedData } from '@/types';
import { DataTable } from "./data-table"
import { Head, Link, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { index, create } from '@/routes/contacts';
import { buttonVariants } from '@/components/ui/button';
import { toast } from 'sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: index().url,
    },
];


export default function ContactIndex({ contacts }: { contacts: Contact[] }) {
    const { flash } = usePage<SharedData>().props;

    if (flash.success) {
        toast.success(flash.success);
    } else if (flash.error) {
        toast.error(flash.error);
    }

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
