import { columns } from "./columns"
import { type Interaction, type BreadcrumbItem, type SharedData } from '@/types';
import { DataTable } from "./data-table"
import { Head, Link, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { index, create } from '@/routes/interactions';
import { buttonVariants } from '@/components/ui/button';
import { toast } from 'sonner';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: index().url,
    },
];

export default function InteractionIndex({ interactions }: { interactions: Interaction[] }) {
    const { flash } = usePage<SharedData>().props;

    console.log(flash);

    // if (flash.success) {
    //     toast.success(flash.success);
    // } else if (flash.error) {
    //     toast.error(flash.error);
    // }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Interactions" />

            <div className="container mx-auto py-10">
                <div className={'mt-8'}>
                    <Link className={buttonVariants({ variant: 'outline' })} href={create().url}>
                        Create Interaction
                    </Link>
                </div>
                <DataTable columns={columns} data={interactions} />
            </div>
        </AppLayout>
    )
}
