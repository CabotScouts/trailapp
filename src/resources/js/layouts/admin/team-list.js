import React from 'react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';

export default function List({ teams, children=false }) {
  return (
    <Frame title="Teams">
      { children &&
        <div className="p-3 bg-blue-600 text-neutral-100">
          <p className="text-lg">{ children }</p>
        </div>
      }
      { (teams.length > 0) && teams.map((t) => <ListItem key={ t.id } target={ route('view-team-submissions', t.id)}>
        <div className="flex-grow pr-5">
          <p className="font-serif text-xl text-medium text-blue-800">{ t.name }</p>
          <p className="text-sm">{ t.group }</p>
        </div>
        <div className="flex-none">
        { (t.submissions > 0) &&
          <div className="w-8 rounded-full text-center text-neutral-100 text-medium text-sm p-2 bg-orange-600">
            <p>{ t.submissions }</p>
          </div>
        }
        </div>
      </ListItem>) }
      { (teams.length == 0) && <p>No teams</p>}
    </Frame>
  )
}
