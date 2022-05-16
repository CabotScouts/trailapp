import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { PencilIcon } from '@heroicons/react/solid';

export default function List({ challenges }) {
  return (
    <Frame title="Challenges">
      { challenges.map((c) => <ListItem key={ c.id } target={ route('view-challenge-submissions', c.id) }>
        <div className="flex-grow pr-5">
          <p className="text-xl text-medium">{ c.name }</p>
          <p className="text-sm">{ c.description }</p>
        </div>
        <div className="flex-none flex">
          <div className="w-8 rounded-xl text-center text-neutral-100 text-medium text-sm p-2 bg-emerald-600">
            <Link href={ route('edit-challenge', c.id) }><PencilIcon /></Link>
          </div>
        </div>
      </ListItem>) }
    </Frame>
  )
}
