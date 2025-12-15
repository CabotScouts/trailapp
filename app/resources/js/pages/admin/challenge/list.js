import React from 'react';
import { Link } from '@inertiajs/react';
import Frame, { Container } from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { PencilIcon } from '@heroicons/react/solid';

export default function List({ challenges }) {
  return (
    <Frame title="Challenges">
      <ButtonBar>
        <Button href={route('add-challenge')}>Add Challenge</Button>
      </ButtonBar>
      <Container>
        {challenges.map((c) => <ListItem key={c.id}>
          <div className="flex-grow pr-5">
            <Link href={route('view-challenge', c.id)}>
              <p className="text-xl text-medium">{c.name}</p>
              <p className="text-sm">{c.points_label}</p>
            </Link>
          </div>
          <div className="flex-none flex items-center">
            <Link href={route('view-challenge-submissions', c.id)}>
              <div className="mr-1 rounded-full text-center text-neutral-100 font-bold text-sm px-3 py-2 bg-indigo-600">
                <p>{c.submissions}</p>
              </div>
            </Link>
            <Link href={route('edit-challenge', c.id)}>
              <div className="w-8 rounded-xl text-center text-neutral-100 text-sm p-2 bg-emerald-600">
                <PencilIcon />
              </div>
            </Link>
          </div>
        </ListItem>)}

        {(challenges.length === 0) &&
          <div className="p-5 text-center">
            <p className="text-medium text-xl">No challenges</p>
          </div>
        }
      </Container>
    </Frame>
  )
}
