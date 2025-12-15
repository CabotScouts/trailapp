import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import Frame from '@/layouts/form/frame';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Select from '@/components/form/select';
import Button from '@/components/form/button';

const Start = (props) => {

  const { data, setData, post, processing, errors, reset } = useForm({
    group: '',
    name: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    post(route('create-team'));
  };

  return (
    <>
      <Head title="Create a team" />
      <Frame>
        {(props.running == true) &&
          <>
            <Header title={props.name}>
              <p>Pick your group and decide on a team name to start the trail</p>
            </Header>

            <Errors errors={errors} />

            <Group onSubmit={submit}>
              <Select title="Group" name="group" onChange={handleChange} required>
                <option value="-">Select your Group</option>
                {props.groups.map(g => (<option key={g.id} value={g.id}>{g.name}</option>))}
              </Select>
              <Input type="text" title="Team Name" name="name" placeholder="Pick a team name" onChange={handleChange} required />
              <Button processing={processing}>Start Trail</Button>
            </Group>
          </>
        }

        {(props.running == false) &&
          <Header title={props.name}>
            <p>This event isn't currently running, come back later!</p>
          </Header>
        }
      </Frame>
    </>
  );
}

Start.layout = null;
export default Start;
