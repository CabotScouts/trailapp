import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { PencilIcon } from '@heroicons/react/solid';

export default function List({ groups }) {
  return (
    <Frame title="Groups">
      <ButtonBar>
        <Button href={ route('add-group') }>Add Group</Button>
      </ButtonBar>
      
      { groups.map((g) => <ListItem key={ g.id }>
        <div className="flex-grow pr-5">
          <Link href={ route('view-group-teams', g.id) }>
            <p className="text-xl text-medium">{ g.name }</p>
          </Link>
        </div>
        <div className="flex-none flex">
          <div className="mr-1 rounded-full text-center text-neutral-100 font-bold text-sm px-3 py-2 bg-cyan-600">
            <p>{ g.teams }</p>
          </div>
          <div className="w-8 rounded-xl text-center text-neutral-100 text-sm p-2 bg-emerald-600">
            <Link href={ route('edit-group', g.id) }><PencilIcon /></Link>
          </div>
        </div>
      </ListItem>) }
      
      { (groups.length === 0) && 
        <div className="p-5 text-center">
          <p className="text-medium text-xl">No groups</p>
        </div>
      }
    </Frame>
  )
}
