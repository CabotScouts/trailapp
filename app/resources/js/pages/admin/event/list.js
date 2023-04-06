import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Frame, { Container } from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { CheckIcon, XIcon, PencilIcon, StarIcon } from '@heroicons/react/solid';

export default function List({ events }) {
  return (
    <Frame title="Events">
      <ButtonBar>
        <Button href={route('new-event')}>New Event</Button>
      </ButtonBar>

      <Container>
        {events.map((e) => <ListItem key={e.id}>
          <div className="flex-grow pr-5">
            <p className="text-xl text-medium">{e.name}</p>
          </div>
          <div className="flex-none flex">
            <Link href={route('toggle-event-running', e.id)}>
              {(e.active == true) &&
                <>
                  {(e.running == true) &&
                    <div className="mr-1 inline-flex items-center px-2 py-2 bg-green-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                      Running
                    </div>
                  }
                  {(e.running == false) &&
                    <div className="mr-1 inline-flex items-center px-2 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                      Not Running
                    </div>
                  }
                </>
              }
            </Link>
            {(e.active == false) &&
              <>
                <Link href={route('toggle-event-active', e.id)}>
                  <div className="mr-1 inline-flex items-center px-2 py-2 bg-gray-400 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                    Not Active
                  </div>
                </Link>
              </>
            }
            <div className="w-8 rounded-xl text-center text-neutral-100 text-sm p-2 bg-emerald-600">
              <Link href={route('edit-event', e.id)}><PencilIcon /></Link>
            </div>
          </div>
        </ListItem>)}

        {(events.length === 0) &&
          <div className="p-5 text-center">
            <p className="text-medium text-xl">No events</p>
          </div>
        }
      </Container>
    </Frame>
  )
}
