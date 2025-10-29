import { ColumnDef } from "@tanstack/react-table"
import { type Contact } from '@/types';
import { Button, buttonVariants } from '@/components/ui/button';
import {
    ArrowDown,
    ArrowUp,
    ArrowUpDown,
} from 'lucide-react';
import * as React from 'react';
import { Checkbox } from "@/components/ui/checkbox"
import { edit, show } from '@/routes/contacts';
import { Link } from '@inertiajs/react';
import { toast } from 'sonner';
import ContactController from '@/actions/App/Http/Controllers/ContactController';

const deleteContact = (id: number) => {
    if (confirm('Are you sure you want to delete this contact?')) {
        ContactController.destroy({ contact: id})
        toast("Contact deleted successfully");
    }
}

export const columns: ColumnDef<Contact>[] = [
    {
        id: "select",
        header: ({ table }) => (
            <Checkbox
                checked={
                    table.getIsAllPageRowsSelected() ||
                    (table.getIsSomePageRowsSelected() && "indeterminate")
                }
                onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
                aria-label="Select all"
            />
        ),
        cell: ({ row }) => (
            <Checkbox
                checked={row.getIsSelected()}
                onCheckedChange={(value) => row.toggleSelected(!!value)}
                aria-label="Select row"
            />
        ),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: "name",
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Name
                    {column.getIsSorted() === "desc" ? (
                        <ArrowDown />
                    ) : column.getIsSorted() === "asc" ? (
                        <ArrowUp />
                    ) : (
                        <ArrowUpDown />
                    )}
                </Button>
            )
        },
        cell: ({ row }) => <div className="lowercase">{row.getValue("name")}</div>,
    },
    {
        accessorKey: "email",
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Email
                    {column.getIsSorted() === "desc" ? (
                        <ArrowDown />
                    ) : column.getIsSorted() === "asc" ? (
                        <ArrowUp />
                    ) : (
                        <ArrowUpDown />
                    )}
                </Button>
            )
        },
        cell: ({ row }) => <div className="lowercase">{row.getValue("email")}</div>,
    },
    {
        accessorKey: "phone",
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Phone
                    {column.getIsSorted() === "desc" ? (
                        <ArrowDown />
                    ) : column.getIsSorted() === "asc" ? (
                        <ArrowUp />
                    ) : (
                        <ArrowUpDown />
                    )}
                </Button>
            )
        },
        cell: ({ row }) => <div className="lowercase">{row.getValue("phone")}</div>,
    },
    {
        accessorKey: "company",
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Company
                    {column.getIsSorted() === "desc" ? (
                        <ArrowDown />
                    ) : column.getIsSorted() === "asc" ? (
                        <ArrowUp />
                    ) : (
                        <ArrowUpDown />
                    )}
                </Button>
            )
        },
        cell: ({ row }) => <div className="lowercase">{row.getValue("company")}</div>,
    },
    {
        id: "actions",
        enableHiding: false,
        cell: ({ row }) => {
            const contact = row.original

            return (
                <>
                <Link href={show({ contact: contact }).url}
                      className={buttonVariants({ variant: 'default' })}>
                    Show
                </Link>
                <Link
                    href={edit({ contact: contact }).url}
                    className={buttonVariants({ variant: 'secondary' })}
                >
                    Edit
                </Link>
                <Button
                    variant="destructive"
                    className={'cusor-pointer'}
                    onClick={() => deleteContact(contact.id)}
                >
                    Delete
                </Button>
                </>
            )
        },
    },
]
