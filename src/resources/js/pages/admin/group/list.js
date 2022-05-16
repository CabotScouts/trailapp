import React from 'react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';

export default function List({ groups }) {
  return (
    <Frame title="Groups">
      { groups.map((g) => <ListItem key={ g.id } target={ route('view-group-teams', g.id) }>
        <div className="flex-grow pr-5">
          <p className="text-xl text-medium">{ g.name }</p>
        </div>
        <div className="flex-none">
          <div className="w-8 rounded-full text-center text-neutral-100 text-medium text-sm p-2 bg-cyan-600">
            <p>{ g.teams }</p>
          </div>
        </div>
      </ListItem>) }
    </Frame>
  )
}
