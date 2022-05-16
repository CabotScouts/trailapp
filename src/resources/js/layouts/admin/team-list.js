import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { XIcon } from '@heroicons/react/solid';

export default function List({ teams, children=false }) {
  return (
    <Frame title="Teams">
      { children &&
        <div className="p-3 bg-blue-600 text-neutral-100">
          <p className="text-lg">{ children }</p>
        </div>
      }
      { (teams.length > 0) && teams.map((t) => <ListItem key={ t.id }>
        <div className="flex-grow pr-5">
          <Link href={ route('view-team-submissions', t.id) }>
            <p className="font-serif text-xl text-medium text-blue-800">{ t.name }</p>
            <p className="text-sm">{ t.group }</p>
          </Link>
        </div>
        <div className="flex-none flex items-center">
        { (t.submissions > 0) &&
          <div className="w-8 mr-2 rounded-full text-center text-neutral-100 text-medium text-sm p-2 bg-orange-600">
            <p>{ t.submissions }</p>
          </div>
        }
          <Link href={ route('delete-team', t.id) }>
            <div className="w-8 rounded-xl text-center text-neutral-100 text-medium text-sm p-2 bg-red-600">
              <XIcon />
            </div>
          </Link>
        </div>
      </ListItem>) }
      { (teams.length === 0) && 
        <div className="p-5 text-center">
          <p className="text-medium text-xl">No teams</p>
        </div>
      }
    </Frame>
  )
}
