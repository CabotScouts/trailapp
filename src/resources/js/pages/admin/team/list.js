import React from 'react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';

export default function List({ teams }) {
  return (
    <Frame title="Teams">
      { teams.map((t) => <ListItem key={ t.id } target={ route('view-team', t.id)}>
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
    </Frame>
  )
}
