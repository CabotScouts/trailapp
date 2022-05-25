import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { ChatIcon, XIcon } from '@heroicons/react/solid';

export default function List({ title="Teams", teams, children=false, simple=false }) {
  return (
    <Frame title={ title }>
      { children &&
        <div className="p-3 bg-blue-600 text-neutral-100">
          <p className="text-lg">{ children }</p>
        </div>
      }
      { (Object.keys(teams).length > 0) && Object.keys(teams).map((key) => <ListItem key={ teams[key].id }>
        <div className="flex-grow pr-5">
          <Link href={ route('view-team-submissions', teams[key].id) }>
            <p className="font-serif text-xl text-medium text-blue-800">{ teams[key].name }</p>
            <p className="text-sm">{ teams[key].group }</p>
          </Link>
        </div>
        <div className="flex-none flex items-center">
        { (teams[key].points > 0) &&
          <div className="mr-2 rounded-full text-center text-neutral-100 font-bold text-sm p-3 bg-green-600">
            <p>{ teams[key].points }</p>
          </div>
        }
        { (teams[key].submissions > 0) &&
          <div className="mr-1 rounded-full text-center text-neutral-100 font-bold text-sm px-3 py-2 bg-orange-600">
            <p>{ teams[key].submissions }</p>
          </div>
        }
        { !simple &&
          <>
            <Link href={ route('broadcast-to-team', teams[key].id) }>
              <div className="w-8 rounded-xl text-center text-neutral-100 p-2 bg-blue-600 mr-2">
                <ChatIcon />
              </div>
            </Link>
            <Link href={ route('delete-team', teams[key].id) }>
              <div className="w-8 rounded-xl text-center text-neutral-100 p-2 bg-red-600">
                <XIcon />
              </div>
            </Link>
          </>
        }
        </div>
      </ListItem>) }
      { (Object.keys(teams).length === 0) && 
        <div className="p-5 text-center">
          <p className="text-medium text-xl">No teams</p>
        </div>
      }
    </Frame>
  )
}
