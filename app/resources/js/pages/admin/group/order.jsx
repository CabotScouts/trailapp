import React from 'react';
import Frame, { Container } from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';

export default function List({ groups }) {
  return (
    <Frame title="Groups">
      <ButtonBar>
        <Button href={route('add-group')}>Save Order</Button>
      </ButtonBar>

      <Container>
        {groups.map((g) => <ListItem key={g.id}>
          <div className="flex-grow pr-5">
            <p className="text-xl text-medium">{g.name}</p>
          </div>
        </ListItem>)}

        {(groups.length === 0) &&
          <div className="p-5 text-center">
            <p className="text-medium text-xl">No groups</p>
          </div>
        }
      </Container>
    </Frame>
  )
}
