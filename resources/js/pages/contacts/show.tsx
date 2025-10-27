import ContactController from '@/actions/App/Http/Controllers/ContactController';
import { type BreadcrumbItem, type Interaction, type Contact } from '@/types';
import { Form, Head,} from '@inertiajs/react';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { index } from '@/routes/contacts';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: index().url,
    },
];


export default function ShowContact({ contact, interactions }: { contact: Contact, interactions: Interaction[] }) {

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Show Contact" />

            <div className="w-full max-w-xl px-4 py-6">

                <div className="space-y-6">
                    <HeadingSmall
                        title={"Show Contact #" + contact.id}
                        description="Show Contact - name, email address, phone number and company name"
                    />

                    <Form
                        {...ContactController.update.form({contact: contact.id})}
                        options={{
                            preserveScroll: true,
                        }}
                        className="space-y-6"
                    >
                        {({ errors }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Name</Label>

                                    <Input
                                        id="name"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="name"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        placeholder="Full name"
                                        value={contact.name}
                                        disabled
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.name}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email address</Label>

                                    <Input
                                        id="email"
                                        type="email"
                                        className="mt-1 block w-full"
                                        name="email"
                                        required
                                        autoFocus
                                        tabIndex={2}
                                        placeholder="Email address"
                                        value={contact.email}
                                        disabled
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.email}
                                    />
                                </div>


                                <div className="grid gap-2">
                                    <Label htmlFor="phone">Phone</Label>

                                    <Input
                                        id="phone"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="phone"
                                        required
                                        autoFocus
                                        tabIndex={3}
                                        placeholder="Phone Number"
                                        value={contact.phone}
                                        disabled
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.phone}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="company">Company</Label>

                                    <Input
                                        id="company"
                                        type="text"
                                        className="mt-1 block w-full"
                                        name="company"
                                        autoFocus
                                        tabIndex={4}
                                        placeholder="Company Name"
                                        value={contact.company}
                                        disabled
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.company}
                                    />
                                </div>


                                <div className="flex items-center gap-4">
                                    <Table>
                                        <TableCaption>A list of your interactions.</TableCaption>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead className="w-[100px]">Interaction Type</TableHead>
                                                <TableHead>Note</TableHead>
                                                <TableHead className="text-right">Timestamp</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {interactions.map((interaction) => (
                                                <TableRow key={interaction.id}>
                                                    <TableCell className="font-medium">{interaction.type}</TableCell>
                                                    <TableCell>{interaction.note}</TableCell>
                                                    <TableCell className="text-right"></TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </div>
                            </>
                        )}
                    </Form>
                </div>
            </div>
        </AppLayout>
    );
}
