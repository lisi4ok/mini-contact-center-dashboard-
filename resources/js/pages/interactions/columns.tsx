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
import { edit, show } from '@/routes/interactions';
import { Link } from '@inertiajs/react';
import { toast } from 'sonner';
import InteractionController from '@/actions/App/Http/Controllers/InteractionController';

const deleteInteraction = (id: number) => {
    if (confirm('Are you sure you want to delete this contact?')) {
        InteractionController.destroy({ interaction: id})
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
        accessorKey: "type",
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Type
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
        cell: ({ row }) => <div className="lowercase">{row.getValue("type")}</div>,
    },
    {
        accessorKey: "note",
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Note
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
        cell: ({ row }) => <div className="w-1"><div className="lowercase">{row.getValue("note")}</div></div>,
    },
    {
        id: "actions",
        enableHiding: false,
        cell: ({ row }) => {
            const interaction = row.original

            return (
                <>
                <Link href={show({ interaction: interaction }).url}
                      className={buttonVariants({ variant: 'default' })}>
                    Show
                </Link>
                <Link
                    href={edit({ interaction: interaction }).url}
                    className={buttonVariants({ variant: 'secondary' })}
                >
                    Edit
                </Link>
                <Button
                    variant="destructive"
                    className={'cusor-pointer'}
                    onClick={() => deleteInteraction(interaction.id)}
                >
                    Delete
                </Button>
                </>
            )
        },
    },
]
